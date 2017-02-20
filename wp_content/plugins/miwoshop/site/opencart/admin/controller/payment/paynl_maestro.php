<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlMaestro extends Pay_Controller_Admin {
    protected $_paymentOptionId = 712;
    protected $_paymentMethodName = 'paynl_maestro';
    
    protected $_defaultLabel = 'Maestro';
    
    
}
