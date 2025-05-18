<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // ヘッダーからリダイレクト先を取得（カスタムコントローラーがセット）
        $redirectTo = $request->headers->get('X-Redirect-To', route('dashboard'));

        return redirect()->intended($redirectTo);
    }
}
