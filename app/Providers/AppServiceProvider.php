<?php

namespace App\Providers;

use App\Lib\SMS\AjuratechSMSSender;
use App\Lib\SMS\ISMSSender;
use App\Lib\SMS\SMSLogger;
use App\Mixin\ResponseMixin;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ISMSSender::class, function ($app) {
            if ($app['config']->get('site.sms.apiKey') && $app['config']->get('site.sms.secretKey')) {
                return new AjuratechSMSSender(
                    $app['config']->get('site.sms.apiUrl'),
                    $app['config']->get('site.sms.apiKey'),
                    $app['config']->get('site.sms.secretKey'),
                    $app['config']->get('site.sms.callerID')
                );
            }

            return new SMSLogger();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ResponseFactory::mixin(new ResponseMixin());
    }
}
