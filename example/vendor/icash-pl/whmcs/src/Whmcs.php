<?php

namespace iCashpl\Whmcs;

use iCashpl\ApiPhp\iCash;

class Whmcs
{
    /** @var iCash */
    protected $icash;
    
    /** @var array */
    protected $numbers = [];
    
    /** @var Order */
    protected $order;
    
    protected $service;
    
    protected $vat = 23;

    /**
     * @param string $app_key
     */
    public function __construct($app_key = null)
    {
        $this->icash = new iCash($app_key);
        $this->order = new Order();
    }
    
    /**
     * @return iCash
     */
    public function icash()
    {
        return $this->icash;
    }
    
    /**
     * @return Order
     */
    public function order()
    {
        return $this->order;
    }
    
    /**
     * @param $vat
     *
     * @return $this
     */
    public function setVat($vat)
    {
        $this->vat = (float)$vat;
        
        return $this;
    }
    
    /**
     * @param array $data
     *
     * @return $this
     */
    public function setNumber(array $data = [])
    {
        $this->numbers[] = new Number($data, $this->vat);
        
        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setNumbers(array $data = [])
    {
        array_map(function ($data) {
            $this->setNumber($data);
        }, $data);
        
        return $this;
    }
    
    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setOrder(array $attributes = [])
    {
        $this->order = new Order($attributes);
        
        return $this;
    }
    
    /**
     * @param string $service_id
     * @param string $service_text
     *
     * @return $this
     */
    public function setService($service_id, $service_text)
    {
        $this->service = [
            'id' => $service_id,
            'text' => $service_text,
        ];
        
        return $this;
    }

    /**
     * @return Number|bool
     */
    public function getNumber()
    {
        $amount = (float)$this->order()->getAmount();
        
        return $this->getNumberItem($amount);
    }
    
    /**
     * @param float $amount
     *
     * @return Number|bool
     */
    protected function getNumberItem($amount)
    {
        foreach ($this->numbers as $number) {
            if ($number->hasBetween($amount)) {
                return $number;
            }
        }
        
        return false;
    }
    
    /**
     * @return string
     */
    public function getServiceId()
    {
        if (array_key_exists('id', $this->service)) {
            return $this->service['id'];
        }
    }
    
    /**
     * @return string
     */
    public function getServiceText()
    {
        if (array_key_exists('text', $this->service)) {
            return $this->service['text'];
        }
    }
    
    /**
     * @param string $code
     *
     * @return bool
     */
    public function getStatusCode($code)
    {
        $this->icash()->getStatusCode([
            'service' => $this->getServiceId(),
            'number' => $this->getNumber()->number,
            'code' => $code,
        ]);
        
        return $this->icash()->statusOk();
    }
}
