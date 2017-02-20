<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;
class ControllerPaymentPaynlMistercash extends Pay_Controller_Admin {
    protected $_paymentOptionId = 436;
    protected $_paymentMethodName = 'paynl_mistercash';
    
    protected $_defaultLabel = 'Mistercash/Bancontact';
    
    
}
