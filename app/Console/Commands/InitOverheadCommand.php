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
                'name' => 'Equipment Maintance',
                'notes' =>  'Taking care of stuff',
                'sort_order' => 1,
                'children' => [
                    [
                        'name' => 'Gas Up',
                        'notes' =>  'Get Gas',
                        'sort_order' => 1,
                        'children' => [
                            [
                                'name' => 'Blue Truck',
                                'notes' =>  'That blue one',
                                'sort_order' => 1
                            ],
                            [
                                'name' => 'Red Truck',
                                'notes' =>  'That red one',
                                'sort_order' => 1
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Driving',
                'notes' =>  'Are we there yet?',
                'sort_order' => 2
            ],        
            [
                'name' => 'Napping',
                'notes' =>  'Do not tell',
                'sort_order' => 3
            ]
        ];        
        
        $this->createAssignments($assignments);
        
        $categories = [
            [
                'name' => 'Work Orders',
                'notes' =>  '',
                'sort_order' => 1
            ],
            [
                'name' => 'Shop',
                'notes' =>  '',
                'sort_order' => 2
            ],        
            [
                'name' => 'Lunch',
                'notes' =>  '',
                'sort_order' => 3
            ],        
            [
                'name' => 'Park Pick Up',
                'notes' =>  '',
                'sort_order' => 4
            ]
        ];        
        
        foreach($categories as $category){
            OverheadCategory::create($category);
        };
        
        
        
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
