<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlClickandbuy extends Pay_Controller_Admin {
    protected $_paymentOptionId = 139;
    protected $_paymentMethodName = 'paynl_clickandbuy';
    
    protected $_defaultLabel = 'ClickandBuy';
    
    
}
