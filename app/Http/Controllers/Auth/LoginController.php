<?php declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Cart\MergeCartWithLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoginController extends Controller
{
    public function __construct(
        private readonly MergeCartWithLogin $mergeCartWithLogin,
    )
    {}
    private $guestID;
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $this->mergeCartWithLogin->execute(Auth::id(), $request->cookie('guestID' ?? $request->session()->getId()));
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()
            ->setStatusCode(401)
            ->withErrors([
                'email' => 'Неверные данные для входа'
            ])->onlyInput('email');

    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'));
    }
}
