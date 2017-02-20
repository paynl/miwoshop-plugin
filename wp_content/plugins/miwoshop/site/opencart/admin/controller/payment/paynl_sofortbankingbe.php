<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlSofortbankingbe extends Pay_Controller_Admin {
    protected $_paymentOptionId = 559;
    protected $_paymentMethodName = 'paynl_sofortbankingbe';
    
    protected $_defaultLabel = 'Sofortbanking België';
    
    
}
