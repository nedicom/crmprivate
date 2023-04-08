@extends('layouts.app')

@section('title')
  Лиды
@endsection

@section('leftmenuone')
  <li class="nav-item text-center p-3">
    <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#leadsModal">Добавить лид</a>
  </li>
  <li class="nav-item text-center p-3">
    <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#SourcesModal">Источники лидов</a>
  </li>
@endsection

@section('main')

    <h2 class="px-3">Лиды</h2>
{{-- start views for all services--}}


  @include('inc/filter.leadfilter')
    <div class="row">
      <table class="table">
        <thead>
          <tr>
            <th scope="col"># </th>
            <th scope="col">Дата обращения</th>
            <th scope="col">Суть проблемы</th>
            <th scope="col">Имя клиента</th>
            <th scope="col">Телефон</th>
            <th scope="col">Консультация</th>
            <th scope="col">Результат</th>
            <th scope="col">Ответственный юрист</th>
            <th scope="col">Привлек</th>
            <th scope="col">Источник</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $el)
            @include('leads/leadrow')
          @endforeach
        </tbody>
      </table>
    </div>

    @include('inc./modal/leadsmodal/addlead')
    @include('inc./modal/leadsmodal/sources')

  <script>
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })
  </script>

  @endsection
