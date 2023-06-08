<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
 
    public function login()
    {
        $credentials = $this->validate(request(), array(
            $this->username()   => 'required|string',
            'password'          => 'required|string'
        ), array(
            'user.required'         => 'Tienes que ingresar tu usuario.',
            'password.required'     => 'Tienes que ingresar tu contraseña.'
        ));

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }else{
            return back()
                ->withErrors([$this->username() => trans('auth.failed')])
                ->withInput(request([$this->username()]));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function username()
    {
        return 'email';
    }
}
