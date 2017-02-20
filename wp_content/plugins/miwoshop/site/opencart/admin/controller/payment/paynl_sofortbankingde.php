<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlSofortbankingde extends Pay_Controller_Admin {
    protected $_paymentOptionId = 562;
    protected $_paymentMethodName = 'paynl_sofortbankingde';
    
    protected $_defaultLabel = 'Sofortbanking Duitsland';
    
    
}
