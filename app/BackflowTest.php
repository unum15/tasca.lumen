<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BackflowTest extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat);
    }

    protected $fillable = [
        'backflow_test_report_id',
        'contact_id',
        'reading_1',
        'reading_2',
        'passed',
        'tested_on',
        'notes'
    ];

    protected $casts = [
        'reading_1' => 'float',
        'reading_2' => 'float',
    ];

    public function backflow_test_report()
    {
        return $this->belongsTo('App\BackflowTestReport');
    }

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}
