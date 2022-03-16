<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */ // View login for admin
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    public function loginAsUser()
    {
        return view('auth.login');
    }

    //! View for register is on FortifyServiceProvider.php

    public function storeAsGuest(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::GUEST);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::GUEST);
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

     // override logout so cart contents remain:
    // https://github.com/bumbummen99/laravelshoppingcart
    public function logout(Request $request)
    {
        $cart = collect(session()->get('cart'));

        $destination = \Auth::logout();

        if (!config('cart.destroy_on_logout')) {
            $cart->each(function ($rows, $identifier) {
                session()->put('cart.' . $identifier, $rows);
            });
        }

        return redirect()->to($destination);
    }

    public function redirectTo()
    {
        return str_replace(url('/'), '', session()->get('previousUrl', '/'));
    }
}
