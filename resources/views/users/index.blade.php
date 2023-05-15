@extends('layouts.app')

@section('title') Пользователи @endsection

@section('leftmenuone')
    <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#addUserModal">Добавить пользователя</a>
    </li>
@endsection

@section('main')
    <h2 class="px-3">Пользователи</h2>
    @include('inc.filter.user-filter')

    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"># </th>
                    <th scope="col">Дата создания</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Email</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Роль</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @include('users._row')
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>

    <!-- Модальное окно -->
    @include('inc.modal.users.add-user')
@endsection
