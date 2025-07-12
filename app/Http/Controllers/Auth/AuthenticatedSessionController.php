<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Handle different roles
        switch($user->role) {
            case 'perusahaan':
                // Check if company profile exists
                $hasProfile = CompanyProfile::where('user_id', $user->id)->exists();
                
                if (!$hasProfile) {
                    return redirect()->route('company.profile.create');
                }
                return redirect()->route('dashboard');

            case 'pemantau':
                return redirect()->route('dashboard');

            case 'admin':
                // Ubah redirect ke route yang ada
                return redirect()->route('dashboard');
                
            case 'reviewer':
                return redirect()->route('dashboard');

            default:
                return redirect()->route('dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
