<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynloverboeking extends Pay_Controller_Payment {
    protected $_paymentOptionId = 136;
    protected $_paymentMethodName = 'paynl_overboeking';
    
    
}
