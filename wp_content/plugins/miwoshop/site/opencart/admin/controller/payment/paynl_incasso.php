<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlIncasso extends Pay_Controller_Admin {
    protected $_paymentOptionId = 137;
    protected $_paymentMethodName = 'paynl_incasso';
    
    protected $_defaultLabel = 'Automatische incasso';
    
    
}
