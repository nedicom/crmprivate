<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Requests\Users\PasswordRequest;
use App\Models\User;
use App\Services\Auth\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    private $register;

    public function __construct(RegisterService $register)
    {
        $this->register = $register;
        $this->middleware('can:manage-users');
    }

    public function index(Request $request)
    {
        $query = User::orderByDesc('id');

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }
        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', '%' . $value . '%');
        }
        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }
        if (!empty($value = $request->get('role'))) {
            $query->where('role', $value);
        }

        $users = $query->paginate(10);

        $statuses = [
            User::STATUS_WAIT => 'Ожидает',
            User::STATUS_ACTIVE => 'Активирован',
        ];

        $roles = User::rolesList();

        return view('users.index', compact('users', 'statuses', 'roles'));
    }


    /**
     * Сохранение пользователя
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $user = User::new(
            $request['name'],
            $request['email'],
            $request['password'],
            $request['role']
        );

        return redirect()->route('users.show', $user)->with('success', 'Пользователь создан.');
    }

    /**
     * Детальная страница
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Обновление пользователя
     * @param UpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email']));

        if ($request['role'] !== $user->role) {
            $user->changeRole($request['role']);
        }

        return redirect()->route('users.show', $user)->with('success', 'Пользователь обновлен.');
    }

    /**
     * Удаление пользователя
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

    /**
     * Активация пользователя
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(User $user)
    {
        $this->register->verify($user->id);

        return redirect()->route('users.show', $user);
    }

    /**
     * Изменение пароля
     * @param User $user
     * @param PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(User $user, PasswordRequest $request)
    {
        $user->update(['password' => Hash::make($request->input('password'))]);

        return redirect()->route('users.index')->with('success', 'Пароль пользователя был изменен.');
    }
}
