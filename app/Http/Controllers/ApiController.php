<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function qne(Request $request)
    {
        $client = new Client();
        $response = $client->get('http://hdsoutlet.qunar.com/api/city/queryCity.json?reqData={"head":{"appKey":"12345678","salt":"123","sign":"063cae89a00896187f80eecbf922364a","version":"3.1.0"}}');
        return $response->getBody();

    }
}
