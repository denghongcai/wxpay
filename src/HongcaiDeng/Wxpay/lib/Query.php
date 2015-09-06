<?php

namespace HongcaiDeng\Wxpay\lib;

trait Query
{
    private $queryURL = 'https://api.mch.weixin.qq.com/pay/orderquery';

    /**
     * 生成接口参数Xml.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function createQueryXml()
    {
        try {
            //检测必填参数
            if ($this->parameters['out_trade_no'] == null) {
                throw new \Exception('缺少查询接口必填参数out_trade_no！'.'<br>');
            }
            $this->parameters['appid'] = $this->wxpay_config['appid'];//公众账号ID
            $this->parameters['mch_id'] = isset($this->wxpay_config['mch_id']) ? $this->wxpay_config['mch_id'] : $this->wxpay_config['mchid'];//商户号
            $this->parameters['nonce_str'] = $this->createNonceStr();//随机字符串
            $this->parameters['sign'] = $this->getSign($this->parameters);//签名
            return  $this->arrayToXml($this->parameters);
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * POST请求查询Xml.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    private function postQueryXml()
    {
        $xml = $this->createQueryXml();
        $response = $this->postXmlCurl($xml, $this->queryURL, $this->curl_timeout);

        return $response;
    }

    /**
     * 获得查询结果.
     *
     * @return array
     */
    public function getQueryResult()
    {
        $response = $this->postQueryXml();
        $result = $this->xmlToArray($response);

        return $result;
    }
}
