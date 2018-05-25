<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function qne(Request $request)
    {
        $uri = '/api/hotel/queryHotelList.json';
        $data['cityCode'] = 'beijing_city';
        $hotelList = Helpers::callApi($uri, $data);
        return $hotelList;

    }
}
