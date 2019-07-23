<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backflow extends Model
{
    protected $table = 'backflows.backflow_assemblies';
    protected $primaryKey = 'backflow_assembly_index';
    public $fillable = [
                        'property_index',
                        'contact_index',
                        'water_system',
                        'use',
                        'placement',
                        'backflow_style_index',
                        'manufacturer',
                        'size',
                        'model_number',
                        'serial_number'                        
                       ];
    
    public function property()
    {
        return $this->belongsTo('App\Property', 'property_index', 'property_index');
    }
    
    public function contact()
    {
        return $this->belongsTo('App\Contact', 'contact_index', 'contact_index');
    }
}
