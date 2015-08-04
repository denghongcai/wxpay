<?php namespace HongcaiDeng\Wxpay\lib;

trait Notify
{

    public $data;//接收到的数据，类型为关联数组
    public $returnParameters;//返回参数，类型为关联数组

    /**
     * 将微信的请求xml转换成关联数组，以方便数据处理
     */
    public function saveData($xml)
    {
        return $this->data = $this->xmlToArray($xml);
    }


    public function checkSign()
    {
        $tmpData = $this->saveData($GLOBALS['HTTP_RAW_POST_DATA']);

        unset($tmpData['sign']);

        $sign = $this->getSign($tmpData);//本地签名
        if ($this->data['sign'] == $sign) {
            return true;
        }
        return false;
    }

    /**
     * 获取微信的请求数据
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置返回微信的xml数据
     */
    public function setReturnParameter($parameter, $parameterValue)
    {
        $this->returnParameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
    }

    /**
     * 将xml数据返回微信
     */
    public function returnXml()
    {
        $returnXml = $this->arrayToXml($this->returnParameters);
        return $returnXml;
    }
}
