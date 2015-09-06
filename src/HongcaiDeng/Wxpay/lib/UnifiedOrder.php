<?php

namespace HongcaiDeng\Wxpay\lib;

use Illuminate\Exception;

trait UnifiedOrder
{
    private $unifiedOrderURL = 'https://api.mch.weixin.qq.com/pay/unifiedorder';

    /**
     * 生成接口参数Xml.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function createUnifiedOrderXml()
    {
        try {
            //检测必填参数
            if ($this->parameters['out_trade_no'] == null) {
                throw new \Exception('缺少统一下单接口必填参数out_trade_no！'.'<br>');
            } elseif ($this->parameters['body'] == null) {
                throw new \Exception('缺少统一下单接口必填参数body！'.'<br>');
            } elseif ($this->parameters['total_fee'] == null) {
                throw new \Exception('缺少统一下单接口必填参数total_fee！'.'<br>');
            } elseif ($this->parameters['notify_url'] == null) {
                throw new \Exception('缺少统一下单接口必填参数notify_url！'.'<br>');
            } elseif ($this->parameters['trade_type'] == null) {
                throw new \Exception('缺少统一下单接口必填参数trade_type！'.'<br>');
            } elseif ($this->parameters['trade_type'] == 'JSAPI' &&
                $this->parameters['openid'] == null) {
                throw new \Exception('统一下单接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！'.'<br>');
            }
            $this->parameters['appid'] = $this->wxpay_config['appid'];//公众账号ID
            $this->parameters['mch_id'] = isset($this->wxpay_config['mch_id']) ? $this->wxpay_config['mch_id'] : $this->wxpay_config['mchid'];//商户号
            $this->parameters['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];//终端ip
            $this->parameters['nonce_str'] = $this->createNonceStr();//随机字符串
            $this->parameters['sign'] = $this->getSign($this->parameters);//签名
            return  $this->arrayToXml($this->parameters);
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * POST请求统一下单Xml.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function postUnifiedOrderXml()
    {
        $xml = $this->createUnifiedOrderXml();
        $response = $this->postXmlCurl($xml, $this->unifiedOrderURL, $this->curl_timeout);

        return $response;
    }

    /**
     * 使用证书POST请求统一下单Xml.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function postUnifiedOrderXmlSSL()
    {
        $xml = $this->createUnifiedOrderXml();
        $response = $this->postXmlSSLCurl($xml, $this->unifiedOrderURL, $this->curl_timeout);

        return $response;
    }

    /**
     * 获取统一下单结果，默认不使用证书.
     *
     * @return mixed
     */
    public function getUnifiedOrderResult()
    {
        $response = $this->postUnifiedOrderXml();
        $result = $this->xmlToArray($response);

        return $result;
    }

    /**
     * 获取prepay_id.
     *
     * @return string
     */
    public function getUnifiedOrderPrepayId()
    {
        if (isset($this->prepay_id) && !is_null($this->prepay_id)) {
            return $this->prepay_id;
        } else {
            $response = $this->postUnifiedOrderXml();
            $result = $this->xmlToArray($response);
            $prepay_id = $result['prepay_id'];

            return $prepay_id;
        }
    }
}
