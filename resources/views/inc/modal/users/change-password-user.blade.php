<div class="modal fade" id="passwordUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class ="modal-header">
                <h2>Сменить пароль пользователя</h2>
            </div>
            <div class ="modal-body d-flex justify-content-center">
                <div class ="col-10">
                    <form action="{{route('users.change-password', $user)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="password">Новый пароль</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password-confirm">Подвтердите пароль</label>
                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" id='submit' class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
