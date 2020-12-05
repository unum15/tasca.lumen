<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AssetServiceType;
use App\AssetUsageType;
use App\AssetType;
use App\AssetUnit;
use App\AssetTimeUnit;


class InitAssetTypesCommand extends Command
{
    protected $signature = 'init:asset-types';

    protected $description = 'Create initial asset related types for Tasca.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $names = [
                'Check',
                'Change',
                'Clean',
                'Replace'
        ];
        $sort = 1;
        foreach($names as $name){
            AssetServiceType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        
        $names = [
            'Miles',
            'Hours'
        ];
        $sort = 1;
        foreach($names as $name){
            AssetUsageType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            "Auto",
            "Trailers",
            "Equipment",
            "Power tools",
            "Hand tools",
            "Specialty tools"
        ];
        $sort = 1;
        foreach($names as $name){
            AssetType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            "OZ",
            "Cups",
            "Quarts",
            "Gallons"
        ];
        $sort = 1;
        foreach($names as $name){
            AssetUnit::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }

        $names = [
            "Day",
            "Week",
            "Month",
            "Year"
        ];
        $sort = 1;
        foreach($names as $name){
            AssetTimeUnit::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
    }
}
