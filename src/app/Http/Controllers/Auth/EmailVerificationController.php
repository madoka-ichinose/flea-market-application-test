<?php
 
declare(strict_types=1);
 
namespace App\Http\Controllers\Auth;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
 
 
class EmailVerificationController extends Controller
{
    /**
	 * 確認メール送信画面
	 */
	public function register()
	{}
	/**
	 * 確認メール送信
	 */
	public function notification()
	{}
 
	/**
	 * メールリンクの検証
	 */
	public function verification()
	{}
}