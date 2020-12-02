<?php
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Contact;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    use DatabaseTransactions;

    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }    

    public function getAdminUser(){
        $user = Contact::where('login', 'admin@example.com')->first();
        return $user;
    }
    
}
