<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Hotel;
use App\HotelList;

class StorageHotel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minsu:hotel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '缓存酒店详情';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //暂时先全量增加吧
        $uri = '/api/hotel/queryHotelDetail.json';
        HotelList::chunk(10, function ($hotelLists) use ($uri) {
            $hotelIds = array_pluck($hotelLists->toArray(), 'hotelId');
            $data['hotelIds'] = implode(',', $hotelIds);
            $hotels = Helpers::callApi($uri, $data);
            if ($hotels['code'] == 0) {
                //调用成功
                foreach ($hotels['result']['hotelDetail'] as $hotel) {
                    $hotelModel = Hotel::where('hotelId', $hotel['hotelId'])->first();
                    if (!$hotelModel) {
                        $hotelModel = new Hotel();
                        $hotelModel->name = @$hotel['detail']['name'];
                        $hotelModel->enName = @$hotel['detail']['enName'];
                        $hotelModel->address = @$hotel['detail']['address'];
                        $hotelModel->starRate = @$hotel['detail']['starRate'];
                        $hotelModel->category = @$hotel['detail']['category'];
                        $hotelModel->phone = @$hotel['detail']['phone'];
                        $hotelModel->fax = @$hotel['detail']['fax'];
                        $hotelModel->establishmentDate = @$hotel['detail']['establishmentDate'];
                        $hotelModel->renovationDate = @$hotel['detail']['renovationDate'];
                        $hotelModel->baiduLat = @$hotel['detail']['baiduLat'];
                        $hotelModel->baiduLon = @$hotel['detail']['baiduLon'];
                        $hotelModel->city = @$hotel['detail']['city'];
                        $hotelModel->businessZone = @$hotel['detail']['businessZone'];
                        $hotelModel->district = @$hotel['detail']['district'];
                        $hotelModel->landmarks = json_encode(@$hotel['detail']['landmarks']);
                        $hotelModel->introEditor = @$hotel['detail']['introEditor'];
                        $hotelModel->description = @$hotel['detail']['description'];
                        $hotelModel->airportPickUpService = @$hotel['detail']['airportPickUpService'];
                        $hotelModel->generalAmenities = @$hotel['detail']['generalAmenities'];
                        $hotelModel->roomAmenities = @$hotel['detail']['roomAmenities'];
                        $hotelModel->images = json_encode(@$hotel['detail']['images']);
                        $hotelModel->thumbnailId = @$hotel['detail']['thumbnailId'];
                        $hotelModel->updateTime = @$hotel['detail']['updateTime'];
                        $hotelModel->commentScore = @$hotel['detail']['commentScore'];
                        $hotelModel->save();
                    }
                }
            }
        });
    }
}
