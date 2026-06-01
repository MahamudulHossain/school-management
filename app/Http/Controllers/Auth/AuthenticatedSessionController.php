<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Branch;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $input = $request->username;
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        } elseif (preg_match('/^\+\d{13}$/', $input)) { // Check for international phone format
            $fieldType = 'cell_phone';
        } else {
            $fieldType = 'personnel_id';
        }

        if (auth()->attempt(array($fieldType => $request->username, 'password' => $request->password))) {

            // Check if the user account is active and has the necessary conditions
            if (auth::user()->web_access == 0) {
                Auth::logout();
                return redirect('/login')
                    ->withErrors(['global' => "Sorry, Account not activated. Please contact the Administrator."]);
            }

            // Regenerate session after successful login
            $request->session()->regenerate();

            // Store default academic year in session
            $acdemic_year = DB::table('academic_years')->orderBy('id','desc')->pluck('title', 'id')->first();
            session()->put('acad_year', $acdemic_year);


            // Redirect to the home page after successful login
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            // Return error if login fails
            return redirect()->route('login')
                ->withErrors(['global' => "Cell-Phone/Email-Address/P_id or Password are wrong."]);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
