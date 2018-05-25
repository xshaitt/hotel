<?php
/**
 * Created by PhpStorm.
 * User: xshaitt
 * Date: 2018/5/25
 * Time: 下午5:42
 */

namespace App\Helpers;

use GuzzleHttp\Client;

class Helpers
{
    public static function callApi($uri)
    {
        $host = env('MINSU_HOST');
        $data['head']['appKey'] = env('MINSU_APPKEY');
        $data['head']['salt'] = env('MINSU_SALT');
        $data['head']['sign'] = md5(md5(env('MINSU_SECRETKEY') . $data['head']['appKey']) . $data['head']['salt']);
        $data['head']['version'] = env('MINSU_VERSION');
        $reqData = json_encode($data);
        $client = new Client();
        $response = $client->get("{$host}{$uri}?reqData={$reqData}");
        $body = json_decode($response->getBody(), true);
        return $body;
    }
}