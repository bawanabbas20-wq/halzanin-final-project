<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // SECURITY (OWASP A07): Graceful 429 response with Retry-After guidance.
        // JSON for AJAX/API callers; redirect-back with flash error for web forms.
        $this->renderable(function (ThrottleRequestsException $e, Request $request) {
            $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;

            if ($request->expectsJson()) {
                return response()->json([
                    'message'     => 'Too many requests. Please try again in ' . $retryAfter . ' seconds.',
                    'retry_after' => (int) $retryAfter,
                ], 429, $e->getHeaders());
            }

            return redirect()->back()
                ->withInput($request->except(['password', 'password_confirmation', 'current_password']))
                ->with('error', 'Too many requests. Please wait ' . $retryAfter . ' seconds before trying again.');
        });
    }
}
