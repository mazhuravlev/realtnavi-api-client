<?php

namespace Velbis\Realtnavi;

use ErrorException;

class API
{

    const PARAM_AREA = 'area';
    const PARAM_TIME = 'time';
    const PARAM_CATEGORIES = 'categories';
    const INFO_AREAS = 'areas';

    private $token, $apiUrl;

    public function __construct($token, $apiUrl)
    {
        $this->token = $token;
        $this->apiUrl = $apiUrl;
    }

    public static function connect($username, $password, $apiUrl)
    {
        $tokenData = self::curlPost(
            $apiUrl . 'login_check',
            array(
                '_username' => $username,
                '_password' => $password
            )
        );
        $tokenJSON = json_decode($tokenData, true);
        if(isset($tokenJSON['token'])) {
            return new API($tokenJSON['token'], $apiUrl);
        } else {
            throw new ErrorException("Failed to connect: $username@$apiUrl");
        }
    }

    public function getCount(array $params)
    {
        $countJSON = $this->apiAction('container/count', $params);
        $countData = json_decode($countJSON, true);
        if(isset($countData['count'])) {
            return intval($countData['count']);
        } else {
            throw new ErrorException("No count in response: $countJSON");
        }
    }

    public function getXML(array $params)
    {
        return $this->apiAction('container/xml', $params);
    }

    public function getJSON(array $params)
    {
        return $this->apiAction('container/offers', $params);
    }

    public function getArray(array $params)
    {
        $json = $this->getJSON($params);
        return json_decode($json, true);
    }

    public function getInfo($key = null)
    {
        $infoJSON = $this->apiAction('container/');
        $info = json_decode($infoJSON, true);
        if(is_null($key)) {
            return $info;
        } else {
            if(is_array($info) and array_key_exists($key, $info)) {
                return $info[$key];
            } else {
                throw new ErrorException("No '$key' key in response");
            }
        }
    }

    private function apiAction($action, array $data = []) {
        return self::curlPost(
            $this->apiUrl . $action,
            $data,
            array("Authorization: Bearer " . $this->token)
        );
    }

    private static function curlPost($url, array $postData = array(), array $httpHeader = array())
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($curl);
    }

}