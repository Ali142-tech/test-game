<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.login', [
            'redirect' => $request->query('redirect'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string'],
            ],
            __('auth.validation'),
            __('auth.attributes')
        );

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => __('auth.login.failed')])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if ($request->user()->isAdmin()) {
            Auth::logout();

            return back()
                ->withErrors(['email' => __('auth.login.admin_only')])
                ->onlyInput('email');
        }

        $redirect = $request->input('redirect');

        return redirect()
            ->to($redirect ?: route('dashboard'))
            ->with(Notify::success('Welcome back, '.$request->user()->name.'!', 'Signed in'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with(Notify::info('You have been signed out.', 'See you soon'));
    }
}
