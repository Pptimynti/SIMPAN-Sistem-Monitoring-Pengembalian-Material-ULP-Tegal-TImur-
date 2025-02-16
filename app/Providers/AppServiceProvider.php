<?php

namespace App\Providers;

use App\Services\Implementations\PekerjaanService;
use App\Services\PekerjaanInterface;
use Carbon\Carbon;
use DB;
use Illuminate\Support\ServiceProvider;
use Log;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        PekerjaanInterface::class => PekerjaanService::class,
    ];
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function ($query) {
            Log::debug('Query :' . $query->sql);
        });

        if (env(key: 'APP_ENV') !== 'local') {
            URL::forceScheme(scheme: 'https');
        }
    }
}
