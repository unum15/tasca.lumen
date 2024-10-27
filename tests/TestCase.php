<?php

use App\Contact;
use App\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use DatabaseTransactions;

    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function getAdminUser()
    {
        $user = Contact::where('login', 'admin@example.com')->first();
        if (empty($user)) {
            $user = Contact::factory(['login' => 'admin@example.com'])->create();
            $admin = Role::where('name', 'admin')->first();
            $user->roles()->attach($admin);
        }

        return $user;
    }
}
