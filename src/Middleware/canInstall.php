<?php

namespace Froiden\LaravelInstaller\Middleware;

use App\Models\User;
use Closure;
use DB;
use Illuminate\Support\Facades\Schema;
/**
 * Class canInstall
 * @package Froiden\LaravelInstaller\Middleware
 */

class canInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if($this->alreadyInstalled()) {
            abort(403, 'این سامانه قبلا نصب شده!  لطفا پس از حذف فایل installed  در مسیر storage\framework\sessions  مجددا رفرش کنید. یا به دیتابیس وصل هستید.');
        }

        $this->changePhpConfigs();

        return $next($request);
    }

    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled()
    {
        $database_connected =false;

//        try {
//            // بررسی اتصال به پایگاه داده با تلاش برای دسترسی به ساختار جداول
//            $database_connected = Schema::hasTable('users');
//            User::count() == 0 ? $database_connected = false : '';
//        } catch (\Exception $e) {
//            // در صورت خطا، کاربر را به صفحه نصب هدایت کنید
//            $database_connected = false;
//        }

//        dd(file_exists(storage_path('installed')) , $ggg);
//        if ($database_connected == true || file_exists(storage_path('installed') ) == true){
        if ( file_exists(storage_path('installed') ) == true){
            return true;
        }else{
            return false;
        }


    }

    private function changePhpConfigs()
    {
        try {
            ini_set('max_execution_time', 0); // Set unlimited execution time
            ini_set('memory_limit', -1);      // Set unlimited memory limit
        } catch (\Exception $e) {
            // Log or report the exception message
            logger()->error('Error changing PHP configurations: ' . $e->getMessage());
        }
    }

}
