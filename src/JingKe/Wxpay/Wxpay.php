<?php namespace JingKe\Wxpay;

use JingKe\Wxpay\JsApi\JsApi;

class Wxpay
{

    public $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function instance($type)
    {
        switch ($type) {
            case 'jsApi':
                return new JsApi($this->config);
                break;
            default:
                return false;
                break;
        }
    }
}
