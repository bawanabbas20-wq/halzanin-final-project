<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // SECURITY: token max:64 prevents oversized token payloads
            'token'    => ['required', 'string', 'max:64'],
            'email'    => ['required', 'email', 'max:254'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // SECURITY: Explicitly enforce token expiry.
        // Laravel's broker treats a NULL/unreadable `created_at` as "now" (via
        // Carbon::parse(null)), which makes a reset token live forever on some DB
        // setups. We reject any token whose `created_at` is missing or older than
        // the configured expiry window, so a stale link can never reset a password.
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->input('email'))
            ->first();

        $expireMinutes = (int) config('auth.passwords.users.expire', 60);

        $tokenExpired = ! $record
            || empty($record->created_at)
            || Carbon::parse($record->created_at)->addMinutes($expireMinutes)->isPast();

        if ($tokenExpired) {
            // Clean up the dead token so it cannot be retried.
            if ($record) {
                DB::table('password_reset_tokens')
                    ->where('email', $request->input('email'))
                    ->delete();
            }

            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => __(Password::INVALID_TOKEN)]);
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
