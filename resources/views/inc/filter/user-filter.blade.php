<form action="{{ route('users.index') }}" method="GET">
    <div class="row p-4">
        <div class="col-2">
            <input placeholder="Введите имя" name="name" id="name" class="form-control" type="text" value="{{ request()->query('name') }}">
        </div>
        <div class="col-2">
            <input placeholder="Введите email" name="email" id="email" class="form-control" type="text" value="{{ request()->query('email') }}">
        </div>
        <div class="col-2">
            <select class="form-select" name="status" id="status">
                <option value="">Выберите статус</option>
                @foreach($statuses as $name => $value)
                    <option value="{{ $name }}" @if (request()->query('status') === $name) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <select class="form-select" name="role" id="role">
                <option value="">Выберите роль</option>
                @foreach(\App\Models\User::rolesList() as $name => $value)
                    <option value="{{ $name }}" @if (request()->query('role') === $name) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-primary">Применить</button>
        </div>
    </div>
</form>
