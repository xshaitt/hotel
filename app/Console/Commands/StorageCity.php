<?php

namespace App\Console\Commands;

use App\City;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

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
        $host = env('MINSU_HOST');
        $uri = '/api/city/queryCity.json';
        $data['head']['appKey'] = env('MINSU_APPKEY');
        $data['head']['salt'] = env('MINSU_SALT');
        $data['head']['sign'] = md5(md5(env('MINSU_SECRETKEY') . $data['head']['appKey']) . $data['head']['salt']);
        $data['head']['version'] = env('MINSU_VERSION');
        $reqData = json_encode($data);
        $client = new Client();
        $response = $client->get("{$host}{$uri}?reqData={$reqData}");
        $body = json_decode($response->getBody(), true);
        $count = 0;
        if ($body['code'] == 0) {
            //调用成功
            foreach ($body['result']['hotelGeoList'] as $city) {
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
