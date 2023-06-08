<?php

namespace App\Helpers;

use App\Helpers\WebHelper;

class IntcomexApi
{
    protected $apiKey, $accessKey, $utcTime, $signature;

    public function __construct() {
        // $this->apiKey = 'fd10f8a2-a240-4779-bef6-cec8291ea88c';
        // $this->accessKey = '3e17240ddf84854e89d234e1dcbd1409649f568210f472d53f953ebdd6242194';
        // date_default_timezone_set('UTC');
        $this->apiKey = '8cbd9a9f-2c94-4a33-aeb8-7624044ab7d1';
        $this->accessKey = '3c1e61bb-3c52-4f5d-831d-4730a773f8b1';
        $this->utcTime = gmdate('Y-m-d').'T'.gmdate('H:i:s').'.310320Z';
        $this->signature = $this->encryptHash256($this->apiKey, $this->accessKey, $this->utcTime);
    }

    public function getCatalog()
    {
        $dataEnviar = array(
            'apiKey' => $this->apiKey,
            'utcTimeStamp' => $this->utcTime,
            'signature' => $this->signature
        );
        $webHelper = new WebHelper();
        $data = new \stdClass();
        // $data = json_decode($webHelper->visitarUrl("https://intcomex-test.apigee.net/v1/getcatalog?".http_build_query($dataEnviar)), 200);
        $data = json_decode($webHelper->visitarUrl("https://intcomex-prod.apigee.net/v1/getcatalog?".http_build_query($dataEnviar)), 200);
        // $data = json_decode($webHelper->visitarUrl("https://intcomex-prod.apigee.net/v1/downloadcatalog?".http_build_query($dataEnviar)), 200);
        return $data;
    }

    public function getConsult()
    {
        $dataEnviar = array(
            'apiKey' => $this->apiKey,
            'utcTimeStamp' => $this->utcTime,
            'signature' => $this->signature,
            'Sku' => 'AE110MSF01'
        );
        $webHelper = new WebHelper();
        $data = new \stdClass();
        // $data = json_decode($webHelper->visitarUrl("https://intcomex-test.apigee.net/v1/getproduct?".http_build_query($dataEnviar)), 200);
        $data = json_decode($webHelper->visitarUrl("https://intcomex-prod.apigee.net/v1/getproduct?".http_build_query($dataEnviar)), 200);
        return $data;
    }

    public function getPrice()
    {
        $dataEnviar = array(
            'apiKey' => $this->apiKey,
            'utcTimeStamp' => $this->utcTime,
            'signature' => $this->signature
        );
        $webHelper = new WebHelper();
        $data = new \stdClass();
        // $data = json_decode($webHelper->visitarUrl("https://intcomex-test.apigee.net/v1/getpricelist?".http_build_query($dataEnviar)), 200);
        $data = json_decode($webHelper->visitarUrl("https://intcomex-prod.apigee.net/v1/getpricelist?".http_build_query($dataEnviar)), 200);
        return $data;
    }

    public function getStock()
    {
        $dataEnviar = array(
            'apiKey' => $this->apiKey,
            'utcTimeStamp' => $this->utcTime,
            'signature' => $this->signature
        );
        $webHelper = new WebHelper();
        $data = new \stdClass();
        // $data = json_decode($webHelper->visitarUrl("https://intcomex-test.apigee.net/v1/getinventory?".http_build_query($dataEnviar)), 200);
        $data = json_decode($webHelper->visitarUrl("https://intcomex-prod.apigee.net/v1/getinventory?".http_build_query($dataEnviar)), 200);
        return $data;
    }

    public function getDownload()
    {
        $dataEnviar = array(
            'apiKey' => $this->apiKey,
            'utcTimeStamp' => $this->utcTime,
            'signature' => $this->signature
        );
        $webHelper = new WebHelper();
        $data = new \stdClass();
        // $data = json_decode($webHelper->visitarUrl("https://intcomex-test.apigee.net/v1/downloadextendedcatalog?".http_build_query($dataEnviar)), 200);
        $data = json_decode($webHelper->visitarUrl("https://intcomex-prod.apigee.net/v1/downloadextendedcatalog?".http_build_query($dataEnviar)), 200);
        return $data;
    }

    public function encryptHash256($key, $access, $utc){
        $str = $key.','.$access.','.$utc;
        $result = hash('sha256', $str);
        return $result;
    }
}