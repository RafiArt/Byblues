<?php

namespace App\Providers;

use App\Models\Link;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The namespace for the application's controllers.
     *
     * @var string|null
     */
    protected $namespace = 'App\Http\Controllers';

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
        // Set locale aplikasi ke bahasa Indonesia
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Ambil input pencarian dari request
                $search = request()->input('search');
                $divisionId = request()->input('division_id');

                // Jika pencarian ada, tambahkan kondisi pencarian
                if ($search || $divisionId) {
                    if (Auth::user()->roles[0]->name == 'administrator') {
                        // Ambil semua links jika pengguna adalah administrator dengan pencarian
                        $links = Link::where(function ($query) use ($search) {
                            $query->where('short_url', 'like', '%' . $search . '%')
                                  ->orWhere('title', 'like', '%' . $search . '%');
                        })
                        ->when($divisionId, function ($query) use ($divisionId) {
                            // Filter berdasarkan division_id melalui relasi user
                            return $query->whereHas('user', function ($userQuery) use ($divisionId) {
                                $userQuery->where('division_id', $divisionId);
                            });
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

                    } else {
                        // Ambil links berdasarkan user yang login dengan pencarian
                        $links = Link::where('user_id', Auth::id())
                                     ->where(function($query) use ($search) {
                                         $query->where('short_url', 'like', '%' . $search . '%')
                                               ->orWhere('title', 'like', '%' . $search . '%');
                                     })
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(10);
                    }
                } else {
                    // Jika tidak ada pencarian, ambil data seperti sebelumnya
                    if (Auth::user()->roles[0]->name == 'administrator') {
                        $links = Link::orderBy('created_at', 'desc')->paginate(10);
                    } else {
                        $links = Link::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
                    }
                }

                // Kirim data $links ke semua view
                $view->with('links', $links);
            }
        });


    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */

}
