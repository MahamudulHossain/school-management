<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use DB;
use Config;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['clear_all', 'cache_clear', 'config_clear', 'view_clear', 'view_cache',
            'route_clear', 'config_cache', 'route_cache', 'storage_link', 'backupDatabase', 'error', 'fallback']]);
    }

    public function switchLang($lang)
    {
//        dd($lang);
        if (array_key_exists($lang, Config::get('languages'))) {
            \Session::put('applocale', $lang);
//        dd($lang);
            \Session::flash('flash_success', trans('all_settings.language_changedmsg'));

        }
        return Redirect::back();
    }

    public function home()
    {
        $user = Auth::user();

        if ($user->user_type_id == 1) {
            return view('dashboard.admin');
        } else {
            return view('dashboard.user');
        }
    }


}
