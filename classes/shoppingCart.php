<?php

class shoppingCart
{

    public $amount = 0;

    /**
     * Construct
     * @param int $amount
     */
    public function __construct($amount = 0)
    {
        $this->amount = $amount;
    }

    /**
     * Getter
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Setter
     * @param int $amount
     */
    public function setAmount($amount = 0)
    {
        $this->amount = $amount;
    }

    /**
     * PayAmount function chose one of the pay strategy
     */
    public function payAmount()
    {
        if ($this->amount >= 500) {
            $payment = new payByCC();
        } else {
            $payment = new payByPayPal();
        }

        $payment->pay($this->amount);
    }
}