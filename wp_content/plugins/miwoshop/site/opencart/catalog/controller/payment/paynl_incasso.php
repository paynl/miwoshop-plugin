<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlincasso extends Pay_Controller_Payment {
    protected $_paymentOptionId = 137;
    protected $_paymentMethodName = 'paynl_incasso';
    
    
}
