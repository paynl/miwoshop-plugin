<?php
$dir = dirname(dirname(dirname(dirname(__FILE__))));
$autoload = $dir.'/Pay/Autoload.php';

require_once $autoload;

class ControllerPaymentPaynlideal extends Pay_Controller_Payment {

    protected $_paymentOptionId = 10;
    protected $_paymentMethodName = 'paynl_ideal';

}
