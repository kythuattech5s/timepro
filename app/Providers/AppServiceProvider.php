<?php

namespace App\Providers;
use \App\Helpers\MailHelper;
use App\Models\UserCourseCombo;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $plusMoreStudentNumber = UserCourseCombo::where('is_forever',1)
                                                ->whereHas('courseCombo',function($q){
                                                    $q->where('all_course',1);
                                                })
                                                ->groupBy('user_id')
                                                ->count();
        view()->share('plusMoreStudentNumber', $plusMoreStudentNumber);
        $this->app->singleton('MailHelper', MailHelper::class);
    }
}
