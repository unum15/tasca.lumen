<?php

namespace App\Providers;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\MailServiceProvider as BaseProvider;
use Log;

class MailServiceProvider extends BaseProvider
{
    /**
     * Register the Illuminate mailer instance.
     *
     * @return void
     */
    protected function registerIlluminateMailer()
    {
        $this->app->singleton('mailer', function ($app) {
            $config = $app->make('config')->get('mail');

            // Once we have create the mailer instance, we will set a container instance
            // on the mailer. This allows us to resolve mailer classes via containers
            // for maximum testability on said classes instead of passing Closures.
            $mailer = new Mailer(
                $app['view'], $app['swift.mailer'], $app['events']
            );

            // The trick
            $mailer->setQueue($app['queue']);

            // Next we will set all of the global addresses on this mailer, which allows
            // for easy unification of all "from" addresses as well as easy debugging
            // of sent messages since they get be sent into a single email address.
            foreach (['from', 'reply_to', 'to'] as $type) {
                $this->setGlobalAddress($mailer, $config, $type);
            }

            return $mailer;
        });
        

        $this->app->alias('mailer', \Illuminate\Mail\Mailer::class);
        //$this->app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
        //$this->app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);
        
        $this->app->alias('mail.manager', \Illuminate\Mail\MailManager::class);
        $this->app->alias('mail.manager', \Illuminate\Contracts\Mail\Factory::class);
        class_alias(\Illuminate\Mail\MailManager::class,'mail.manager');
        class_alias(\Illuminate\Contracts\Mail\Factory::class,'mail.factory');
        class_alias(\Illuminate\Mail\Mailer::class,'mailer');
 
        $this->app->configure('mail');
    }
}