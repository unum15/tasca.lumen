<?php

namespace App\Providers;

use App\Contact;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $bearer_token = $request->header('authorization');
            $bearer_token = preg_replace('/^Bearer\s*/', '', $bearer_token);
            if (!empty($bearer_token)) {
                return Contact::whereHas('logIns', function ($query) use ($bearer_token) {
                    $query->where('bearer_token', $bearer_token);
                })->first();
            }
        });

        Gate::define('edit-settings', function (Contact $contact) {
            $perm_count = 0;
            $roles = $contact->roles;
            $roles->map(function ($role){
                $perm_count += $role->permissions()->where('name','edit-settings')->count;
            });
            return $perm_count;
        });
    }
}
