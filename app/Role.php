<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

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