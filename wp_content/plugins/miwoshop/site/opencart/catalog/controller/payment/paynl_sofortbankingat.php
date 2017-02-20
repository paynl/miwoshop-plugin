<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlsofortbankingat extends Pay_Controller_Payment {
    protected $_paymentOptionId = 568;
    protected $_paymentMethodName = 'paynl_sofortbankingat';
    
    
}
