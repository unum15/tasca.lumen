<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\OverheadAssignment;
use App\OverheadCategory;

class InitOverheadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:overhead';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create initial overhead assignments and categories.';

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
        $assignments = [
            [
                'name' => 'Stores',
                'children' => [
                    [
                        'name' =>'Durks',
                    ],
                    [
                        'name' =>'SSC',
                    ],
                    [
                        'name' =>'MLS',
                    ],
                    [
                        'name' => 'SW'
                    ]
                ],
                'categories' => [
                    'Driving'
                ],
            ],
            [
                'name' => 'Vehicle',
                'categories' => [
                    'Shop',
                    'Gas',
                    'Wash',
                    'Repairing'
                ]
            ],
            [
                'name' => 'Shop Time'
            ],
            [
                'name' => 'Heavy Equipment',
                'categories' => [
                    'Maintenance',
                    'Repairing',
                    'Cleaning'
                ]
            ],
            [
                'name' => 'Gas Equipment',
                'categories' => [
                    'Maintenance',
                    'Repairing',
                    'Cleaning'
                ],
            ],
            [
                'name' => 'Office',
                'categories' => [
                    'Design',
                    'Financial',
                    'Schedule'
                ]
            ],
            [
                'name' => 'Inventory'
            ]
        ];        
        
        $this->createAssignments($assignments);


        $categories = [
            [
                'name' => 'Driving',
            ],
            [
                'name' => 'Shop',
            ],
            [
                'name' => 'Gas',
            ],
            [
                'name' => 'Wash',
            ],
            [
                'name' => 'Maintenance',
            ],
            [
                'name' => 'Repairing',
            ],
            [
                'name' => 'Cleaning',
            ],
            [
                'name' => 'Design',
            ],
            [
                'name' => 'Financial',
            ],
            [
                'name' => 'Schedule',
            ]
        ];

        foreach($categories as $category){
            OverheadCategory::create($category);
        };
        
        
        foreach($assignments as $assignment_name){
            $assignment = OverheadAssignment::where('name', $assignment_name['name'])->first();
            if(isset($assignment_name['categories'])){
                foreach($assignment_name['categories'] as $category_name){
                    $category = OverheadCategory::where('name', $category_name)->first();
                    $assignment->overhead_categories()->attach($category);
                }
            }
        }
    }
    
    public function createAssignments($assignments, $parent=null){
        foreach($assignments as $assignment){
            if($parent){
                $assignment['parent_id'] = $parent;
            }
            $new = OverheadAssignment::create($assignment);
            if(isset($assignment['children'])){
                $this->createAssignments($assignment['children'], $new->id);
            }
        };
    }
}
