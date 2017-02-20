<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlsofortbankingbe extends Pay_Controller_Payment {
    protected $_paymentOptionId = 559;
    protected $_paymentMethodName = 'paynl_sofortbankingbe';
    
    
}
