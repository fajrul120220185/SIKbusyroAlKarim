<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\MKelas;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Gantilah dengan cara Anda mendapatkan data dari model
            $kelas = MKelas::orderBy('kelas', 'asc')->get();
            $tanggal = Carbon::now();
            $klsSpp = MKelas::orderBy('id', 'asc')->first();
            if (!empty($klsSpp)) {
                $klsForSPP = $klsSpp->id;
            }else {
                $klsForSPP = null;

            }
            
            $view->with('kelas', $kelas)->with('tanggal', $tanggal)->with('klsForSPP', $klsForSPP);
        });
    }
}
