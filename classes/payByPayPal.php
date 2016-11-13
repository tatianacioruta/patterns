<?php

/**
 * Class payByPayPal
 */
class payByPayPal implements payStrategy
{
    /**
     * Pay with paypal
     * @param int $amount
     */
    public function pay($amount = 0)
    {
        $data = array(
            'price' =>$amount
        );
        $view = new View();
        $view->load('paypal/paypal_form', $data);
    }

}
