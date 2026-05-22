<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BackflowAssembly extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat);
    }

    protected $fillable = [
        'property_id',
        'property_unit_id',
        'contact_id',
        'backflow_type_id',
        'backflow_water_system_id',
        'backflow_size_id',
        'backflow_manufacturer_id',
        'backflow_model_id',
        'active',
        'month',
        'use',
        'placement',
        'gps',
        'serial_number',
        'notes',
        'property_account_id',
        'need_access'
    ];

    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    public function property_account()
    {
        return $this->belongsTo('App\PropertyAccount');
    }
    
    public function property_unit()
    {
        return $this->belongsTo('App\PropertyUnit');
    }

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

    public function backflow_type()
    {
        return $this->belongsTo('App\BackflowType');
    }

    public function backflow_water_system()
    {
        return $this->belongsTo('App\BackflowWaterSystem');
    }

    public function backflow_size()
    {
        return $this->belongsTo('App\BackflowSize');
    }

    public function backflow_manufacturer()
    {
        return $this->belongsTo('App\BackflowManufacturer');
    }

    public function backflow_model()
    {
        return $this->belongsTo('App\BackflowModel');
    }
    
    public function backflow_test_reports()
    {
        return $this->hasMany('App\BackflowTestReport')->orderBy('report_date', 'desc');
    }
}
