<?php

namespace App\Console\Commands;

use App\Helpers\Helpers;
use App\HotelList;
use Illuminate\Console\Command;

class StorageHotelList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minsu:hotel-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '缓存酒店列表';

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
        $uri = '/api/hotel/queryHotelList.json';
        $data['cityCode'] = 'beijing_city';
        $hotelList = Helpers::callApi($uri, $data);
        $count = 0;
        if ($hotelList['code'] == 0) {
            foreach ($hotelList['result']['hotels'] as $hotel) {
                //保存城市数据到数据库
                $hotelModel = HotelList::where('hotelId', $hotel['hotelId'])->first();
                if (!$hotelModel) {
                    $hotelModel = new HotelList();
                    $hotelModel->hotelId = $hotel['hotelId'];
                    $hotelModel->updatedTime = $hotel['updatedTime'];
                    $hotelModel->hotelSeq = $hotel['hotelSeq'];
                    $hotelModel->save();
                    $count++;
                }
            }
        }
        $this->info("本次一共添加了{$count}个酒店");
    }
}
