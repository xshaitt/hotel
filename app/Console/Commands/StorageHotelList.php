<?php

namespace App\Console\Commands;

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
        //
    }
}
