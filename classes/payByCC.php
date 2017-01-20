<?php

/**
 * Strategy Pattern
 * Class PayByCC
 */
class PayByCC implements PayStrategy
{

    private $ccNum = '';
    private $ccType = '';
    private $cvvNum = '';
    private $ccExpMonth = '';
    private $ccExpYear = '';

    /**
     * Pay with CreditCart
     * @param int $amount
     */
    public function pay($amount = 0)
    {
        echo "Paying " . $amount . " using Credit Card";
    }

}