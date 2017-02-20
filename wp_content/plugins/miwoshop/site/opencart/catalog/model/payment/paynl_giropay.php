<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ModelPaymentPaynlGiropay extends Pay_Model {
    protected $_paymentMethodName = 'paynl_giropay';
    

}
?>