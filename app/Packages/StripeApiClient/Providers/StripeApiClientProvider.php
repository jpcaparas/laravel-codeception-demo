<?php
namespace App\Packages\StripeApiClient\Providers;

use App\Contracts\StripeApiClient as StripeApiClientContract;
use App\Packages\StripeApiClient\Config\ApiClientConfig;
use App\Packages\StripeApiClient\StripeApiClient;
use Illuminate\Support\ServiceProvider;

class StripeApiClientProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StripeApiClientContract::class, function() {
            return new StripeApiClient();
        });
    }
}
