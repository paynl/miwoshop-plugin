<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlIdeal extends Pay_Controller_Admin {
    protected $_paymentOptionId = 10;
    protected $_paymentMethodName = 'paynl_ideal';
    
    protected $_defaultLabel = 'iDeal';
    
    
}
