<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlMinitixsms extends Pay_Controller_Admin {
    protected $_paymentOptionId = 808;
    protected $_paymentMethodName = 'paynl_minitixsms';
    
    protected $_defaultLabel = 'Minitix - SMS';
    
    
}
