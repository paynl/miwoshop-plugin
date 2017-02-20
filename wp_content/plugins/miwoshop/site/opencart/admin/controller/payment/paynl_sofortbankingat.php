<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlSofortbankingat extends Pay_Controller_Admin {
    protected $_paymentOptionId = 568;
    protected $_paymentMethodName = 'paynl_sofortbankingat';
    
    protected $_defaultLabel = 'Sofortbanking Zwitserland';
    
    
}
