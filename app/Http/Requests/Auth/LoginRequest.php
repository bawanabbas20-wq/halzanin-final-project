<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Accepts either an email address or a KRG gov_id (e.g. KRG-ABCD1234-EF56)
            'email'    => ['required', 'string', 'max:254'],
            // SECURITY: max:72 = bcrypt safe limit; bcrypt silently truncates at 72 bytes
            'password' => ['required', 'string', 'max:72'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login    = trim($this->string('email')->toString());
        $password = $this->string('password')->toString();
        $remember = $this->boolean('remember');

        // Detect gov_id: matches KRG-XXXXXXXX-XXXX (case-insensitive)
        if (preg_match('/^KRG-[A-Z2-9]{8}-[A-Z2-9]{4}$/i', $login)) {
            $user = User::where('gov_id', strtoupper($login))->first();

            if (! $user || ! Auth::attempt(
                ['email' => $user->email, 'password' => $password],
                $remember
            )) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }
        } else {
            // Standard email login
            if (! Auth::attempt(
                ['email' => $login, 'password' => $password],
                $remember
            )) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
