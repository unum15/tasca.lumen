<?php
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Contact;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    use DatabaseTransactions;
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }    

    public function getAdminUser(){
        $user = Contact::where('login', 'unum@unum5.org')->first();
        return $user;
    }
    
}
