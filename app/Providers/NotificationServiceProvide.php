<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvide extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $file = app_path('Helpers/Notifications/Helper.php');
        if (file_exists($file))
        {
            require_once($file);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }


}
