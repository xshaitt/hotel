<?php

namespace App\Console\Commands;

use App\City;
use App\Helpers\Helpers;
use Illuminate\Console\Command;


class StorageCity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minsu:city';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '缓存城市数据';

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
        $uri = '/api/city/queryCity.json';
        $citys = Helpers::callApi($uri);
        $count = 0;
        if ($citys['code'] == 0) {
            //调用成功
            foreach ($citys['result']['hotelGeoList'] as $city) {
                //保存城市数据到数据库
                $cityModel = City::where('cityCode', $city['cityCode'])->first();
                if (!$cityModel) {
                    $cityModel = new City();
                    $cityModel->provinceId = $city['provinceId'];
                    $cityModel->provinceName = $city['provinceName'];
                    $cityModel->cityName = $city['cityName'];
                    $cityModel->cityCode = $city['cityCode'];
                    $cityModel->parentCityCode = $city['parentCityCode'];
                    $cityModel->save();
                    $count++;
                }
            }
        }
        $this->info("本次一共添加了{$count}个城市");
    }
}
