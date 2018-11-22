<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Auth;

class QueueCountProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('OPDMS.reception.queue.header_status', function($view)
        {
            $view->with('queue_count', DB::select("
                                    SELECT COUNT(*) as total, assignations.status FROM queues
                                    LEFT JOIN assignations
                                        ON assignations.patients_id = queues.patients_id
                                        AND assignations.clinic_code = ".Auth::user()->clinic."
                                        AND DATE(assignations.created_at) = CURDATE()
                                    WHERE queues.clinic_code = ".Auth::user()->clinic."
                                    AND DATE(queues.created_at) = CURDATE()
                                    GROUP BY assignations.status
                                "));

        });


        view()->composer('OPDMS.reception.notification', function($view)
        {
            $view->with('outgoing_referrals', DB::table('refferals')
                            ->where([
                                [DB::raw('DATE(refferals.created_at)'), DB::raw('CURDATE()')],
                                ['refferals.from_clinic', Auth::user()->clinic]
                            ])
                            ->count());

            $view->with('incoming_referrals', DB::table('refferals')
                ->where([
                    [DB::raw('DATE(refferals.created_at)'), DB::raw('CURDATE()')],
                    ['refferals.to_clinic', Auth::user()->clinic]
                ])
                ->count());


            /*$view->with('charged_patients', DB::table('ancillaryrequist')
                ->where([
                    [DB::raw('DATE(ancillaryrequist.created_at)'), DB::raw('CURDATE()')],
                    ['cashincomecategory.clinic_id', Auth::user()->clinic]
                ])
                ->leftJoin('cashincomesubcategory', 'cashincomesubcategory.id', 'ancillaryrequist.cashincomesubcategory_id')
                ->leftJoin('cashincomecategory', 'cashincomecategory.id', 'cashincomesubcategory.cashincomecategory_id')
                ->groupBy('ancillaryrequist.patients_id')
                ->count());*/

            $view->with('charged_patients', DB::select("
                            SELECT COUNT(*) AS total
                            FROM
                            (
                            SELECT COUNT(ancillaryrequist.patients_id) 
                            FROM ancillaryrequist
                            LEFT JOIN cashincomesubcategory ON cashincomesubcategory.id = ancillaryrequist.cashincomesubcategory_id
                            LEFT JOIN cashincomecategory ON cashincomecategory.id = cashincomesubcategory.cashincomecategory_id
                            WHERE DATE(ancillaryrequist.created_at) = CURDATE()
                            AND cashincomecategory.clinic_id = ".Auth::user()->clinic."
                            GROUP BY ancillaryrequist.patients_id
                                ) Charging"));



            $view->with('followup_notification', DB::table('followup')
                ->where([
                    [DB::raw('DATE(followup.followupdate)'), DB::raw('CURDATE()')],
                    ['followup.clinic_code', Auth::user()->clinic]
                ])
                ->count());

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
