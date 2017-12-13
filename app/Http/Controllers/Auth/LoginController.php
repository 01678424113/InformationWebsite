<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $meta_keyword = Setting::where('setting_page', 'index')->where('key_setting', 'keyword')->first();
        $logo = Setting::where('setting_page', 'logo')->where('key_setting', 'logo')->first();
        $logo = $logo->value_setting;
        $meta_keyword = $meta_keyword->value_setting;
        $url_home = 'http://' . env('URL_DOMAIN');
        $url_top_500 = 'http://' . env('URL_DOMAIN') . '/top-500';
        view()->share('url_home', $url_home);
        view()->share('url_top_500', $url_top_500);
        view()->share('logo', $logo);
        view()->share('meta_keyword', $meta_keyword);
        $this->middleware('guest')->except('logout');
    }
}
