<?php


namespace App\Utils;

use App\Models\Config;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;


/**

 * @package App\Utils
 */









    /**
     * 生成带签名的请求头
     * @param $req_method
     * @param $param
     * @param $uri
     * @return array
     */
     function generateHeaders($req_method, $param, $uri)
    {
        $time = time();
        $nonce = rand(100000, 999999);
        $app_id = 200000164;
        $secret_id = 'JIRMZ6O3Qm5KDwCHsgYnlxatGeXq7dfFcjEk';
        $secret_key = 'wZn5NeGCqxg4r8XaDum2EMzRhIvWHtcU';
        $header_str = "X-TC-Key={$secret_id}&X-TC-Nonce={$nonce}&X-TC-Timestamp={$time}";
        $http_str = "{$req_method}\n{$header_str}\n{$uri}\n{$param}";
        $signature = base64_encode(hash_hmac("sha256", $http_str, $secret_key));
        return [
            'X-TC-Key' => $secret_id,
            'X-TC-Timestamp' => $time,
            'X-TC-Nonce' => $nonce,
            'AppId' => $app_id,
            'X-TC-Signature' => $signature,
            'content-type' => 'application/json'];
    }


     function request($uri, $method, $headers = null, $data = null)
    {
        $host ='https://api.meeting.qq.com';
        $client = new Client(['base_uri' => $host, 'timeout' => 20]);
        try {
            $res = $client->request($method, $uri, ['headers' => $headers, 'json' => $data]);
            $data = json_decode($res->getBody()->getContents(), true);
            return ['code' => 200, 'msg' => 'success', 'data' => $data];
        } catch (\Exception $e) {
            Log::error($e);
            return ['code' => $e->getCode(), 'msg' => $e->getMessage(), 'data' => null];
        }
    }

