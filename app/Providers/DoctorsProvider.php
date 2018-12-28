<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DoctorsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('OPDMS.doctors.queue.header_status', function($view)
        {
            $view->with('queue_count', DB::select("
                                    SELECT COUNT(assignations.status) AS total, assignations.status
                                    FROM assignations
                                    WHERE assignations.clinic_code = ".Auth::user()->clinic."
                                    AND assignations.doctors_id = ".Auth::user()->id."
                                    AND DATE(assignations.created_at) = CURDATE()
                                    GROUP BY assignations.status
                                "));

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
