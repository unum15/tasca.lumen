<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AssetLocation;


class InitAssetLocationsCommand extends Command
{
    protected $signature = 'init:asset-locations';

    protected $description = 'Create initial asset locations for Tasca.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $names = [
                'Shop',
                'Garage',
                'Trailer'
        ];
        $sort = 1;
        foreach($names as $name){
            AssetLocation::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
    }

}
