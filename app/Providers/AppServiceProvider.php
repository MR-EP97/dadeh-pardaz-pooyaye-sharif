<?php

namespace App\Providers;

use App\Interfaces\SubmitRequestRepositoryInterface;
use App\Repositories\SubmitRequestRepository;
use App\Services\Repository\SubmitRequestService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SubmitRequestRepositoryInterface::class, SubmitRequestRepository::class);
        $this->app->bind(SubmitRequestService::class, function ($app) {
            return new SubmitRequestService($app->make(SubmitRequestRepository::class));
        });

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
