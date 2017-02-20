<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlminitixsms extends Pay_Controller_Payment {
    protected $_paymentOptionId = 808;
    protected $_paymentMethodName = 'paynl_minitixsms';
    
    
}
