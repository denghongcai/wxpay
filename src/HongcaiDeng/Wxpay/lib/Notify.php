<?php namespace HongcaiDeng\Wxpay\lib;

trait Notify
{
    /**
     * 检查签名
     *
     * @return bool
     */
    public function checkSign()
    {
        $data = $this->xmlToArray($GLOBALS['HTTP_RAW_POST_DATA']);

        unset($data['sign']);

        $sign = $this->getSign($data);//本地签名
        if ($data['sign'] == $sign) {
            return [true, $data];
        }
        return [false, $data];
    }
}
