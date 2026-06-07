<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'min:2', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:254', 'unique:'.User::class],
            // SECURITY: phone format restricted to E.164-like characters only
            'phone_number' => ['nullable', 'string', 'max:20', 'regex:/^[+\d\s\-()\[\]]+$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'password'     => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Generate and send OTP
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->forceFill([
            'otp_code'       => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(10),
        ])->save();

        // Send the OTP email, but never let a mail outage abort registration.
        try {
            Mail::send('emails.otp', ['otp' => $otp, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Your verification code — ' . config('app.name'));
            });
        } catch (\Throwable $e) {
            Log::error('Failed to send OTP email during registration', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
            session()->flash('status', 'We could not send your verification code by email. Please use the "Resend code" option on the next page.');
        }

        Auth::login($user);

        return redirect()->route('otp.verify');
    }
}
