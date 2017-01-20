<?php

namespace iCashpl\Whmcs;

class Number extends Model
{
    /**
     * @param array $attributes
     * @param float $vat
     */
    public function __construct(array $attributes = [], $vat)
    {
        parent::__construct($attributes);
        
        $this->fill($vat);
    }

    /**
     * @param float $amount
     *
     * @return bool
     */
    public function hasBetween($amount)
    {
        $min = (float)$this->getAttribute('min');
        $max = (float)$this->getAttribute('max');
        
        return ($min <= $amount && $max > $amount);
    }
    
    /**
     * @param int $vat
     *
     * @return string
     */
    public function getGross($vat = 23)
    {
        return number_format($this->getAttribute('gross'), 2);
    }
    
    /**
     * @return string
     */
    public function getNet()
    {
        return number_format($this->getAttribute('net'), 2);
    }
    
    /**
     * @param float $vat
     *
     * @return mixed
     */
    protected function fill($vat)
    {
        $vat = (float)$vat / 100;
        $net = (float)$this->getAttribute('net');
        $gross = (float)$this->getAttribute('gross');
        
        if ($net > 0 && $gross > 0) {
            return;
        }
        
        if ($net == 0 && $gross > 0) {
            $this->setAttributes([
                'net' => round(($gross * $vat) / (1 + $vat), 2),
            ]);
            
            return;
        }
        
        if ($gross == 0 && $net > 0) {
            $this->setAttributes([
                'gross' => round(($net * $vat) + $net, 2),
            ]);
            
            return;
        }
    }
}
