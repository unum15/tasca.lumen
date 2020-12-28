<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Notifications\ResetPassword;

class Contact extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable;

    protected $fillable = [
        'name',
        'notes',
        'activity_level_id',
        'contact_method_id',
        'login',
        'password',
        'api_token',
        'show_help',
        'show_maximium_activity_level_id',
        'default_service_window',
        'pending_days_out',
        'creator_id',
        'updater_id',
        'google_calendar_token',
        'google_calendar_id',
        'backflow_certification_number',
        'phreebooks_id'
    ];
    
    protected $hidden = [
        'password','google_calendar_token','google_calendar_id','remember_token','api_token'
    ];
    
    public function activityLevel()
    {
        return $this->belongsTo('App\ActivityLevel');
    }
    
    public function clients()
    {
        return $this->belongsToMany('App\Client')
            ->withTimestamps()
            ->withPivot('contact_type_id');
    }
    
    public function clientContactTypes()
    {
        return $this->hasMany('App\ClientContactType');
    }
    
    public function contactMethod()
    {
        return $this->belongsTo('App\ContactMethod');
    }
    
    public function emails()
    {
        return $this->hasMany('App\Email')->orderBy('email_type_id');
    }
    
    public function phoneNumbers()
    {
        return $this->hasMany('App\PhoneNumber')->orderBy('phone_number_type_id');
    }
    
    public function properties()
    {
        return $this->belongsToMany('App\Property')
            ->orderBy('name')
            ->withTimestamps();
    }
    
    public function logIns()
    {
        return $this->hasMany('App\LogIn');
    }
    
    public function can($ability, $arguments = []){
        return true;
    }
    
    public function getEmailAttribute(){
        return $this->login;
    }
    
    public function sendPasswordResetNotification($token) {
        $notification = new ResetPassword($token);
        $notification->createUrlUsing(function ($token) {
            $link =  $url = url(route('password.reset', [
                'token' => $this->token,
                'email' => $this->login,
            ], false));
            $link = preg_replace('/\/api/','',$link);
            return $link;
        });
        $this->notify($notification);
    }
    
}
