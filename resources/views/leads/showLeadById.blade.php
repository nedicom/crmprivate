@extends('layouts.app')

@section('title')
  лид
@endsection

@section('leftmenuone')
  <li class="nav-item text-center p-3">
    <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#editleadModal">Редактировать лид</a>
  </li>
  <li class="nav-item text-center p-3">
    <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#modalleadtowork">В работу</a>
  </li>
  <li class="nav-item text-center p-3">
    <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#modalleadtoclient">В клиента</a>
  </li>
  <li class="nav-item text-center p-3">
    <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#modalleaddelete">Удалить</a>
  </li>
@endsection

@section('main')

<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>

  <h2 class="px-3">Лид</h2>

  <div class="col-md-6 my-3 mx-3">
        <div class="card border-light">
          <div class="card-header d-flex justify-content-between">
              <h2 class="h3 mb-0 col-8">Инфорация о лиде</h2>
              <h3>{{$data -> status}}</h3>
          </div>
          <div class="card-body row mb-4 d-flex justify-content-center">

              <div class="row">
                  <div class="col-3">ФИО</div>
                  <h4 class="col-9">{{$data -> name}}</h4>
              </div>
              <div class="row">
                  <div class="col-3">Телефон</div>
                  <h4 class="col-9">{{$data -> phone}}</h4>
              </div>

              <div class="row mt-5">
                <div class="col-4">
                    <h5>создан</h5>
                    <p>{{$data -> created_at}}</p>
                  </div>
                  <div class="col-4">
                    <h5>изменен</h5>
                    <p>{{$data -> updated_at}}</p>
                  </div>
                  <div class="col-4">
                    <h5>Что предлагаем</h5>
                    <p>{{$data -> servicesFunc -> name}}</p>
                  </div>
              </div>

              <div class="row my-2">
                  <div class="col-3">Описание</div>
                  <div class="col-9">{{$data -> description}}</div>
              </div>

              <div class="row my-2">
                  <div class="col-3">Что делаем с лидом</div>
                  <div class="col-9">{{$data -> action}}</div>
              </div>

              <div class="row my-2">
                  <div class="col-3">Причина успеха</div>
                  <div class="col-9">{{$data -> successreason}}</div>
              </div>

              <div class="row my-2">
                  <div class="col-3">Причина неудачи</div>
                  <div class="col-9">{{$data -> failurereason}}</div>
              </div>

              <div class="row">
                <div class="col-4">
                    <h6>Источник</h6>
                    <p>{{$data -> source}}</p>
                  </div>
                  <div class="col-4">
                    <h6>Привлек</h6>
                    <p>{{$data -> userFunc -> name}}</p>
                  </div>
                  <div class="col-4">
                    <h6>Ответсвенный</h6>
                    <p>{{$data -> responsibleFunc -> name}}</p>
                  </div>
              </div>
          </div>
        </div>


          <div class="card-footer text-center">
            <div class="mt-3 row d-flex justify-content-center">
                <div class="mt-3 row d-flex justify-content-center">
                    <div class="col-2 mb-3">
                      <a class="btn btn-light w-100" href="#" data-bs-toggle="modal" data-bs-target="#editleadModal" data-toggle="tooltip" data-placement="top" title="Редактировать">
                      <i class="bi-pen"></i></a>
                    </div>
                    <div class="col-2 mb-3">
                      <a class="btn btn-light w-100" href="#" data-bs-toggle="modal" data-bs-target="#modalleadtowork" data-toggle="tooltip" data-placement="top" title="Перевести в работу">
                      <i class="bi-briefcase"></i></a>
                    </div>
                    <div class="col-2 mb-3">
                      <a class="btn btn-light w-100" href="#"
                      data-toggle="tooltip" data-placement="top" title="Перевести в клиента"
                      data-bs-toggle="modal" data-bs-target="#modalleadtoclient">
                      <i class="bi-person-check"></i></a>
                    </div>
                    <div class="col-2 mb-3">
                      <a class="btn btn-light w-100
                      @if ($data -> status == 'конвертирован')
                      disabled
                      @endif
                      " href="#" data-toggle="tooltip" data-placement="top" title="Удалить"
                      data-bs-toggle="modal" data-bs-target="#modalleaddelete">
                      <i class="bi-trash"></i></a>
                    </div>
                  </div>
            </div>
          </div>
      </div>

      @include('../inc/modal/leadsmodal/editlead')
      @include('inc/modal/leadsmodal/leadtowork')
      @include('inc/modal/leadsmodal/leadtoclient')
      @include('inc/modal/leadsmodal/leaddelete')
@endsection
