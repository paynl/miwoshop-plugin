<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlEbon extends Pay_Controller_Admin {
    protected $_paymentOptionId = 998;
    protected $_paymentMethodName = 'paynl_ebon';
    
    protected $_defaultLabel = 'eBon';
    
    
}
