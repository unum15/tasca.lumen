<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }
    
    public function contacts()
    {
        return $this->belongsToMany('App\Contact');
    }
}