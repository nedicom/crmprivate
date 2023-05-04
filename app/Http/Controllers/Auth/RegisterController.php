<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;
use App\Models\User;

class RegisterController extends Controller
{
    private $service;

    public function __construct(RegisterService $service)
    {
        //$this->middleware('guest');
        $this->service = $service;
    }

    /**
     * Регистрация пользователя
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $this->service->register($request);

        return redirect()->route('login')
            ->with('success', 'Проверьте свою электронную почту и нажмите на ссылку для подтверждения.');
    }

    /**
     * Подтверждение регистрации пользователя по токену
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($token)
    {
        if (!$user = User::where('remember_token', $token)->first()) {
            return redirect()->route('login')
                ->with('error', 'К сожалению, ваша ссылка не может быть идентифицирована.');
        }

        try {
            $this->service->verify($user->id);

            return redirect()->route('login')->with('success', 'Ваш адрес электронной почты подтвержден. Теперь вы можете войти.');
        } catch (\DomainException $e) {
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }
}
