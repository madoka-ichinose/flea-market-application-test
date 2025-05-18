<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Session;

class RedirectIfProfileNotSet
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $user = $event->user;
        
        if (! $user->profile_completed) {
            // プロフィール未設定なら、リダイレクト先を変更
            // return redirect(...) はこの場所では効果がないので、以下のように設定値を変える
            config(['fortify.home' => '/mypage/profile']); // Fortify 使用時
            config(['app.redirect_after_verification' => '/mypage/profile']); // 任意のキー（次の方法で利用）
        }
    }
}
