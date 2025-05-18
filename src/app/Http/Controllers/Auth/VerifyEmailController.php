<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if (!$request->user()->hasVerifiedEmail()) {
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        }

        return $request->user()->profile_completed
        ? redirect(RouteServiceProvider::HOME . '?verified=1')
        : redirect('/mypage/profile');
    }

    private function redirectAfterVerification($user)
    {
        if (!$user->profile_completed) {
        return redirect('/mypage/profile');
        }

        return redirect(RouteServiceProvider::HOME . '?verified=1');
    }
}
