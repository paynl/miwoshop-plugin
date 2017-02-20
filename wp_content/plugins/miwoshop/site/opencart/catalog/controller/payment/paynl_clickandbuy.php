<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlclickandbuy extends Pay_Controller_Payment {
    protected $_paymentOptionId = 139;
    protected $_paymentMethodName = 'paynl_clickandbuy';
    
    
}
