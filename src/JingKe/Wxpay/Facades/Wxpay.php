<?php namespace JingKe\Wxpay\Facades;

use Illuminate\Support\Facades\Facade;

class Wxpay extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'wxpay';
    }
}
