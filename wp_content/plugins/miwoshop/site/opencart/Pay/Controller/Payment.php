<?php

class Pay_Controller_Payment extends Controller {

    protected $_paymentOptionId;
    protected $_paymentMethodName;

    public function index() {
        $this->data['button_confirm'] = 'Betalen';
        $this->data['paymentMethodName'] = $this->_paymentMethodName;

        $this->load->model('setting/setting');
        $settings = $this->model_setting_setting->getSetting('paynl');
        
        $serviceId = $settings[$this->_paymentMethodName . '_serviceid'];

         // paymentoption ophalen
        $this->load->model('payment/' . $this->_paymentMethodName);
        $modelName = 'model_payment_' . $this->_paymentMethodName;
        $paymentOption = $this->$modelName->getPaymentOption($serviceId, $this->_paymentOptionId);
        
        if(!$paymentOption){
            die('Payment method not available');
        } 
        
        $this->data['optionSubList'] = array();
        
        if(!empty($paymentOption['optionSubs'])){
             $this->data['optionSubList']  = $paymentOption['optionSubs'];
        }
       
        $this->template = 'default/template/payment/paynl3.tpl';

        $this->render();
    }

    public function startTransaction() {
        $this->load->model('payment/' . $this->_paymentMethodName);

        $this->load->model('checkout/order');
        $this->load->model('setting/setting');
        $settings = $this->model_setting_setting->getSetting('paynl');

        $statusPending = $settings[$this->_paymentMethodName . '_pending_status'];

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        // var_dump($order_info);

        $response = array();
        try {
            $apiStart = new Pay_Api_Start();
            $apiStart->setApiToken($settings[$this->_paymentMethodName . '_apitoken']);
            $apiStart->setServiceId($settings[$this->_paymentMethodName . '_serviceid']);

            $returnUrl = $this->url->link('payment/' . $this->_paymentMethodName . '/finish');
            $exchangeUrl = $this->url->link('payment/' . $this->_paymentMethodName . '/exchange');

            $apiStart->setFinishUrl($returnUrl);
            $apiStart->setExchangeUrl($exchangeUrl);


            $apiStart->setPaymentOptionId($this->_paymentOptionId);
            $amount = round($order_info['total'] * 100);
            $apiStart->setAmount($amount);

            $apiStart->setCurrency($order_info['currency_code']);

            $optionSub = null;
            if (!empty($_POST['optionSubId'])) {
                $optionSub = $_POST['optionSubId'];
                $apiStart->setPaymentOptionSubId($optionSub);
            }
            $apiStart->setDescription($order_info['order_id']);
            $apiStart->setExtra1($order_info['order_id']);


            // Klantdata verzamelen en meesturen
            $strAddress = $order_info['shipping_address_1'] . ' ' . $order_info['shipping_address_2'];
            list($street, $housenumber) = Pay_Helper::splitAddress($strAddress);
            $arrShippingAddress = array(
                'streetName' => $street,
                'streetNumber' => $housenumber,
                'zipCode' => $order_info['shipping_postcode'],
                'city' => $order_info['shipping_city'],
                'countryCode' => $order_info['shipping_iso_code_2'],
            );

            $initialsPayment = substr($order_info['payment_firstname'], 0, 10);
            $initialsShipping = substr($order_info['shipping_firstname'], 0, 10);

            $strAddress = $order_info['payment_address_1'] . ' ' . $order_info['payment_address_2'];
            list($street, $housenumber) = Pay_Helper::splitAddress($strAddress);
            $arrPaymentAddress = array(
                'initials' => $initialsPayment,
                'lastName' => $order_info['payment_lastname'],
                'streetName' => $street,
                'streetNumber' => $housenumber,
                'zipCode' => $order_info['payment_postcode'],
                'city' => $order_info['payment_city'],
                'countryCode' => $order_info['payment_iso_code_2'],
            );


            $arrEnduser = array(
                'initials' => $initialsShipping,
                'lastName' => $order_info['shipping_lastname'],
                'language' => $order_info['language_code'],
                'emailAddress' => $order_info['email'],
                'address' => $arrShippingAddress,
                'invoiceAddress' => $arrPaymentAddress,
            );

            $apiStart->setEnduser($arrEnduser);

            $totalAmount = 0;

            //Producten toevoegen
            foreach ($this->cart->getProducts() as $product) {
                $price = round($product['price'] * 100);
                $totalAmount += $price * $product['quantity'];
                $apiStart->addProduct($product['product_id'], $product['name'], $price, $product['quantity'], 'H');
            }

            // Shipping costs?
            if (isset($this->session->data['shipping_method']['cost']) && $this->session->data['shipping_method']['cost'] != 0) {
                $shippingCost = round($this->session->data['shipping_method']['cost'] * 100);

                $apiStart->addProduct('0', 'Shipping', $shippingCost, 1, 'H');
                $totalAmount += $shippingCost;
            }

            //correctieregel maken, zodat het totaal altijd klopt
            $amount = round($order_info['total'] * 100);
            $correctie = $amount - $totalAmount;
            if ($correctie != 0) {
                $apiStart->addProduct('0', 'Correctie', $correctie, 1, 'H');
            }

            $postData = $apiStart->getPostData();

            $result = $apiStart->doRequest();

            //transactie is aangemaakt, nu loggen
            $modelName = 'model_payment_' . $this->_paymentMethodName;
            $this->$modelName->addTransaction($result['transaction']['transactionId'], $order_info['order_id'], $this->_paymentOptionId, $amount, $postData, $optionSub);

            $message = 'Pay.nl Transactie aangemaakt. TransactieId: ' . $result['transaction']['transactionId'] . ' .<br />';

            if($settings[$this->_paymentMethodName . '_send_confirm_email'] == 'start'){
                $this->model_checkout_order->confirm($order_info['order_id'], $statusPending, $message, true);
            }

            $response['success'] = $result['transaction']['paymentURL'];
        } catch (Pay_Api_Exception $e) {
            $response['error'] = "De pay.nl api gaf de volgende fout: " . $e->getMessage();
        } catch (Pay_Exception $e) {
            $response['error'] = "Er is een fout opgetreden: " . $e->getMessage();
        } catch (Exception $e) {
            $response['error'] = "Onbekende fout: " . $e->getMessage();
        }

        die(json_encode($response));
    }

    public function finish() {
        $this->load->model('payment/' . $this->_paymentMethodName);

        $transactionId = $_GET['orderId'];

        $modelName = 'model_payment_' . $this->_paymentMethodName;
        try{
            $status = $this->$modelName->processTransaction($transactionId);
        } catch(Exception $e){
            // we doen er niks mee, want redirecten moeten we sowieso.
        }

        if ($status == Pay_Model::STATUS_COMPLETE) {
            header("Location: " . $this->url->link('checkout/success'));
            die();
        } else {
            header("Location: " . $this->url->link('checkout/checkout'));
            die();
        }
    }

    public function exchange() {
        $this->load->model('payment/' . $this->_paymentMethodName);


        $transactionId = $_GET['order_id'];
        $modelName = 'model_payment_' . $this->_paymentMethodName;
        if($_GET['action'] == 'pending'){
            $message = 'ignoring PENDING';
        } else{
            try {
                $status = $this->$modelName->processTransaction($transactionId);
                $message = "Status updated to $status";
            } catch (Pay_Api_Exception $e) {
                $message = "Api Error: " . $e->getMessage();
            } catch (Pay_Exception $e) {
                $message = "Plugin error: " . $e->getMessage();
            } catch (Exception $e) {
                $message = "Unknown error: " . $e->getMessage();
            }
        }
        echo "TRUE|" . $message;
        die();
    }

}
