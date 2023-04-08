@extends('layouts.app')

@section('title')
  Клиент
@endsection

@section('head')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="/resources/datetimepicker/jquery.datetimepicker.css">
    <script type="text/javascript">
        $(document).ready(function(){
            $('input#date').datetimepicker({
                lang: 'ru',
                step: 5,
            });
        });
    </script>
@endsection

@section('footerscript')
    <script src="/resources/datetimepicker/jquery.datetimepicker.full.js"></script>
@endsection

@section('leftmenuone')
  <li class="nav-item text-center p-3">
    <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#editModal">Редактировать клиента</a>
  </li>
@endsection

@section('main')

<h2 class="px-3">Клиент</h2>
    <div class= 'col-md-6 col-xxl-3 my-3'>
      <div class= 'card border-light'>
        <div class= 'd-inline-flex justify-content-end px-2'>
          @if ($data -> status == 1)
              <i class="bi bi-circle-fill" style = "color: #0acf97;"></i>
          @else
              <i class="bi bi-circle-fill text-secondary"></i>
          @endif
        </div>
        <div class="text-center">
          <h5 class="mb-2 px-3 text-muted">{{$data -> name}}</h5>
          <p class="mb-0 text-muted">{{$data -> phone}}</p>
          <p class="mb-0 text-muted">{{$data -> email}}</p>
          <p class="mb-0 text-muted">закреплен за: </br>{{$data -> userFunc -> name}}</p>
          <p class="mb-0 text-muted">Код telegram: @if (auth()->user()->role == 'admin' || auth()->user()->id == $data -> lawyer) {{$data -> tgid}} @else скрыто @endif</p>
          <hr class="bg-dark-lighten my-3">
          <div class="mt-3 px-3 row d-flex justify-content-center">
              <div class="col-4 mb-3">
                <a class="btn btn-light w-100" href="#" data-bs-toggle="modal" data-bs-target="#editModal">
                <i class="bi-pen"></i></a>
              </div>
              <div class="col-4 mb-3">
                <a class="btn btn-light w-100" href="{{ route ('Client-Delete', $data->id) }}">
                <i class="bi-trash"></i></a>
              </div>
              <div class="col-4 mb-3">
                  <a class="btn btn-light w-100 nameToForm" href="#"
                  dataclient="{{$data -> name}}" datavalueid="{{$data -> id}}" data-bs-toggle="modal" data-bs-target="#taskModal">
                  <i class="bi-clipboard-plus"></i></a>
               </div>
          </div>
        </div>
      </div>
    </div>

    <div class= 'col-md-9 col-xxl-9 my-3'>
      <div class= 'card border-light'>
        <div class="text-center">
          <h6 class="mb-2 px-3 text-muted">задачи <span>({{$data -> tasksFunc -> count()}})</span></h6>
          <hr class="bg-dark-lighten my-3">
          @foreach(($data -> tasksFunc) as $task)
            <div class="mx-3 d-flex justify-content-start">
              <p class="mt-3 mx-3 text-start">{{$task->created_at->month}} / {{$task->created_at->day}}</p>
              <p class="mt-3 mx-3 text-center col-2">{{$task->status}}</p>
              <a class="mt-3 mx-3 text-start" href="/tasks/{{$task->id}}" target="_blank">{{$task->name}}</a>
            </div>
          @endforeach
          <h6 class="mb-2 px-3 text-muted">платежи <span>({{$data -> serviceFunc -> count()}})</span></h6>
          <hr class="bg-dark-lighten my-3">
            <div class="row">
              <div class="col-8">
                @foreach(($data -> serviceFunc) as $payments)
                    <div class="mx-3 d-flex justify-content-end">
                      <p class="mt-3 mx-3 text-start">{{$payments->name}}</p>
                    </div>
                  @endforeach
              </div>
              <div class="col-4">
                @foreach(($data -> paymentsFunc) as $payment)
                  <div class="mx-3 d-flex justify-content-end">
                    <p class="mt-3 mx-3 text-start">{{$payment->created_at->month}} / {{$payment->created_at->day}}</p>
                    <p class="mt-3 mx-3 text-center col-2">{{$payment->summ}}</p>
                    <a class="mt-3 mx-3 text-start" href="/payments/{{$payment->id}}" target="_blank">{{$payment->name}}</a>
                  </div>
                @endforeach
              </div>
            </div>
        </div>
      </div>
    </div>

    @include('inc/modal/addtask')
@endsection
