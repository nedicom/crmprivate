@extends('layouts.app')

@section('title')
  Изменить клиента
@endsection

@section('main')
<div class ="text-center container col-md-9">
  <form action="{{route('Client-Update-Submit', $data -> id)}}" method="post">
    @csrf
    <div class="form-group mb-3">
      <label for="name">Введите Имя</label>
      <input type = "text" name="name" placeholder="Иван Васильевич" id="name" value='{{$data->name}}' class="form-control">
    </div>
    <div class="form-group mb-3">
      <label for="phone">Введите телефон</label>
      <input type = "phone" name="phone" placeholder="+7" id="phone" value='{{$data->phone}}' class="form-control">
    </div>
    <div class="form-group mb-3">
      <label for="phone">Введите email</label>
      <input type = "email" name="email" placeholder="ivanov@yandex.ru" id="email" value='{{$data->email}}' class="form-control">
    </div>
    <div class="form-group mb-3">
      <select class="form-select" name="source" id="source" aria-label="Default select example">
        <option value="Не знаю источник" selected>Не знаю источник</option>
        <option value="сайт">Сайт</option>
        <option value="Рекомендация">Рекомендация</option>
        <option value="С улицы">С улицы</option>
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
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="status" id="status" value="1" @if (($data -> status) == 1) checked @else @endif>
      <label class="form-check-label" for="flexSwitchCheckDefault">В работе</label>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
  </form>

  </div>
</div>
@endsection
