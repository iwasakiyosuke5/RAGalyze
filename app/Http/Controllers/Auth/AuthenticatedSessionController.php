<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
        
        if ($request->employee_id == '99999' && $request->password == 'administer') {
            if (!Auth::attempt(['employee_id' => $request->employee_id, 'password' => $request->password], $request->boolean('remember'))) {
                throw ValidationException::withMessages([
                    'employee_id' => __('The provided credentials do not match our records.'),
                ]);
            }
    
            $request->session()->regenerate();
            
            // 管理者ページにリダイレクト
            return redirect()->route('userAdmin');
        }

        if (!Auth::attempt(['employee_id' => $request->employee_id, 'password' => $request->password], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'employee_id' => __('The provided credentials do not match our records.'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
