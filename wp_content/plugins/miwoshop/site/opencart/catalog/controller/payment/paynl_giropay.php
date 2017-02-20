<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlgiropay extends Pay_Controller_Payment {
    protected $_paymentOptionId = 694;
    protected $_paymentMethodName = 'paynl_giropay';
    
    
}
