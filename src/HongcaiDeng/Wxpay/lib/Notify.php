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
        $data = $this->xmlToArray(file_get_contents('php://input'));

        $sign = $this->getSign($data);//本地签名
        if ($data['sign'] == $sign) {
            return [true, $data];
        }
        return [false, $data];
    }
}
