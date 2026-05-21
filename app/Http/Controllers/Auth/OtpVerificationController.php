<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (Auth::user()->email_verified_at) {
            return redirect()->intended(route('dashboard'));
        }

        return view('auth.verify-otp');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate(['otp' => ['required', 'string', 'size:6', 'regex:/^\d{6}$/']]);

        $user = Auth::user();

        if (! $user->otp_code || ! $user->otp_expires_at) {
            return back()->withErrors(['otp' => 'No OTP found. Please request a new one.']);
        }

        if (now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'This code has expired. Please request a new one.']);
        }

        if (! Hash::check($request->otp, $user->otp_code)) {
            return back()->withErrors(['otp' => 'Incorrect code. Please try again.']);
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'otp_code'          => null,
            'otp_expires_at'    => null,
        ])->save();

        return redirect()->route('dashboard');
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->forceFill([
            'otp_code'       => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(10),
        ])->save();

        Mail::send('emails.otp', ['otp' => $otp, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your verification code — ' . config('app.name'));
        });

        return back()->with('resent', true);
    }
}
