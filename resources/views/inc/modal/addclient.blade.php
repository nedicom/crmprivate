<div class="modal fade" id="myModal">
  <div class="modal-dialog">
        <div class="modal-content">
    <div class ="modal-header">
      <h2>Добавить клиента</h2>
    </div>

    <div class ="modal-body">
      <form action="{{route('add-client')}}" method="post">
        @csrf
        <div class="form-group mb-3">
          <label for="name">Введите Имя <span class="text-danger">*</span></label>
          <input type = "text" name="name" value="{{ old('name') }}" placeholder="Иван Васильевич" id="name" class="form-control" reqired>
        </div>
        <div class="form-group mb-3">
          <label for="phone">Введите телефон <span class="text-danger">*</span></label>
          <input type = "phone" name="phone" value="{{ old('phone') }}" placeholder="+7" id="phone" class="form-control" reqired>
        </div>
        <div class="form-group mb-3">
          <label for="email">Введите email</label>
          <input type = "email" name="email" value="{{ old('email') }}" placeholder="ivanov@yandex.ru" id="email" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label for="address">Введите адрес</label>
          <input type = "text" name="address" value="{{ old('address') }}" placeholder="295000, Симферополь, ул. Кирова, 15" id="address" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label for="source">Укажите источник</label>
          <select class="form-select" name="source" value="{{ old('source') }}" id="source" class="form-control">
                @foreach($datasource as $el)
                  <option value="{{$el -> name}}">{{$el -> name}}</option>
                @endforeach
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="lawyer">Укажите юриста</label>
          <select class="form-select" name="lawyer" id="lawyer">
                @foreach($datalawyers as $el)
                  <option value="{{$el -> id}}">{{$el -> name}}</option>
                @endforeach
          </select>
        </div>

        <div class="form-group mb-3">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="status" id="status" value="1" checked>
            <label class="form-check-label" for="flexSwitchCheckDefault">В работе</label>
          </div>
        </div>
      </div>

    <div class ="modal-footer">
        <button type="submit" class="btn btn-primary">Сохранить</button>
      </form>
    </div>
    </div>
  </div>
</div>
