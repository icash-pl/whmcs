<?php

namespace iCashpl\Whmcs;

class Order extends Model
{
    /**
     * @return string
     */
    public function getAmount()
    {
        return number_format(str_replace([',', ' '], ['.', ''], $this->getAttribute('amount')), 2);
    }
}
