@extends('layouts.app')

@section('title') Пользователь @endsection

@section('leftmenuone')
    <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal">Редактировать пользователя</a>
    </li>
    <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#passwordUserModal">Сменить пароль</a>
    </li>
    <li class="nav-item text-center p-3">
        <form action="{{ route('users.destroy', $user  ) }}" method="POST" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger w-100" data-toggle="tooltip" data-placement="top" title="Удалить">
                Удалить
            </button>
        </form>
    </li>
@endsection

@section('main')
    <h2 class="px-3">Пользователь</h2>

    <div class="col-md-6 my-3 mx-3">
        <div class="card border-light">
            <div class="card-header d-flex justify-content-between">
                <h2 class="h3 mb-0 col-8">Информация о пользователе</h2>
            </div>
            <div class="card-body row mb-4 d-flex justify-content-center">
                <div class="row">
                    <div class="col-3">Имя</div>
                    <h4 class="col-9">{{$user->name}}</h4>
                </div>
                <div class="row">
                    <div class="col-3">Email</div>
                    <h4 class="col-9">{{$user->email}}</h4>
                </div>
                <div class="row mt-5">
                    <div class="col-4">
                        <h5>создан</h5>
                        <p>{{$user->created_at}}</p>
                    </div>
                    <div class="col-4">
                        <h5>изменен</h5>
                        <p>{{$user->updated_at}}</p>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-3">Cтатус</div>
                    <div class="col-9"><span>{{ \App\Helpers\UserHelper::nameStatus($user) }}</span></div>
                </div>
                <div class="row my-2">
                    <div class="col-3">Роль</div>
                    <div class="col-9"><span>{{ \App\Helpers\UserHelper::nameRole($user) }}</span></div>
                </div>
            </div>
        </div>

        <div class="card-footer text-center">
            <div class="mt-3 row d-flex justify-content-center">
                <div class="mt-3 row d-flex justify-content-center">
                    <div class="col-2 mb-3">
                        <a class="btn btn-light w-100" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal" data-toggle="tooltip" data-placement="top" title="Редактировать">
                            <i class="bi-pen"></i>
                        </a>
                    </div>
                    <div class="col-2 mb-3">
                        <a class="btn btn-dark w-100" href="#" data-bs-toggle="modal" data-bs-target="#passwordUserModal" data-toggle="tooltip" data-placement="top" title="Сменить пароль">
                            <i class="bi bi-lock"></i>
                        </a>
                    </div>
                    <div class="col-2 mb-3">
                        <form action="{{ route('users.destroy', $user  ) }}" method="POST" class="mr-1">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100" data-toggle="tooltip" data-placement="top" title="Удалить">
                                <i class="bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-2 mb-3">
                        @if ($user->isWait())
                            <form method="POST" action="{{ route('users.verify', $user) }}" class="mr-1">
                                @csrf
                                <button class="btn btn-success">Активировать</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('inc.modal.users.edit-user')
    @include('inc.modal.users.change-password-user')
@endsection
