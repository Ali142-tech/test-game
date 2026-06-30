<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Notify;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.register', [
            'redirect' => $request->query('redirect'),
            'countries' => collect(require resource_path('data/countries.php')),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $countries = collect(require resource_path('data/countries.php'));
        $countryCodes = $countries->pluck('code')->all();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone_country' => ['required', 'string', 'in:'.implode(',', $countryCodes)],
            'phone_dial_code' => ['required', 'string', 'max:8'],
            'phone' => ['required', 'string', 'regex:/^[0-9\s\-()]{7,20}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $country = $countries->firstWhere('code', $data['phone_country']);
        if (! $country || $country['dial'] !== $data['phone_dial_code']) {
            return back()
                ->withErrors(['phone_country' => 'Please choose a valid country code from the list.'])
                ->withInput();
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_country' => $data['phone_country'],
            'phone_dial_code' => $data['phone_dial_code'],
            'phone' => preg_replace('/\D+/', '', $data['phone']),
            'password' => $data['password'],
            'is_admin' => false,
        ]);

        event(new Registered($user));

        Auth::login($user);
        $request->session()->regenerate();

        $redirect = $request->input('redirect');

        return redirect()
            ->to($redirect ?: route('dashboard'))
            ->with(Notify::success('Your GoalPass account is ready. Start browsing World Cup matches!', 'Welcome aboard'));
    }
}
