<?php

// CLIENT
class ApekApi
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    protected $apiUser;
    protected $apiSecret;
    protected $apiHost;

    protected $disableSSLChecks = false;
    
    public $debug = false;

    public function __construct($apiUser, $apiSecret, $apiHost)
    {
        $this->apiUser = $apiUser;
        $this->apiSecret = $apiSecret;
        $this->apiHost = $apiHost;
    }

    public function sendRequest($url, $method, array $params)
    {        		
        $url = $this->apiHost . $url;
        
        if (self::METHOD_GET === $method && sizeof($params)) {
            $url .= '?' . http_build_query($params, '', '&');
        }

        if ($this->debug) printf("[CLIENT] url: %s\n", $url);
        if ($this->debug) printf("[CLIENT] method: %s\n", $method);

        $parsed_url = parse_url ($url);
        $path_query = '/' . isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $path_query .= isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $path_query = strtolower(urlencode(strtolower($path_query)));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        $postData = '';
        $headerData = array();
        if (self::METHOD_POST === $method) {
            $postData = json_encode($params);

            array_push($headerData,
	        'Content-Length: ' . mb_strlen($postData),
	        'Content-Type: application/json'
	    );

            if ($this->debug) printf("[CLIENT] post data: %s\n", $postData);

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }	        

        $request_time = time();
        $nonce = strtolower(str_replace("-", "", trim($this->newGuid(), "{}")));

        $hash_sign = md5($this->apiUser . $this->apiSecret . $method . $path_query . $request_time . $nonce . $postData);

 	array_push($headerData, 'Authorization: '. sprintf('a-token %s:%s:%s:%s', $this->apiUser, $hash_sign, $nonce, $request_time));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);

        if ($this->disableSSLChecks) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 

        if (curl_errno($ch)) {
            if ($this->debug) printf("[CLIENT] curl_error: %s\n", curl_error($ch));
            return;
        }

        curl_close($ch);

        if ($this->debug) printf("[CLIENT] Server response code: %d\n", $code);

        if ($code !== 200) {
            // TODO: handle 50x 40x and log somewhere
            if ($this->debug) printf("[CLIENT] Server error: %s\n", $result);
            return;
        }

        $decodeResult = json_decode($result, true);

        if (is_null($decodeResult)) {
            if ($this->debug) printf("[CLIENT] Server sent invalid data: %s\n", $result);
            return;
        }

        return $decodeResult;
    }


    public function disableSSLChecks()
    {
        $this->disableSSLChecks = true;
    }

    private function newGuid()
    {
        if (function_exists("com_create_guid") === true)
        {
            return com_create_guid();
        }

        return sprintf("{%04X%04X-%04X-%04X-%04X-%04X%04X%04X}", mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
