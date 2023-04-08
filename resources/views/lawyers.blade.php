@extends('layouts.app')

@section('title')
  Юристы
@endsection

@section('main')
    <h2 class="px-3">Юристы</h2>
{{-- start views for all lawyers--}}

@foreach($data as $el)

  <div class= 'col-md-6 col-xxl-3 my-3'>
    <div class= 'card border-light'>
      <div class="text-center">

        <div class="d-flex justify-content-between align-items-center m-3">
          <h5 class="mx-2 text-muted text-truncate">{{$el -> name}}</h5>
          
          <div>
            <img src="{{ $el -> avatar }}" style="width: 40px; height:40px" class="rounded-circle" alt="...">
          </div>
         </div>

        <p class="mb-0 text-muted">{{$el -> phone}}</p>

        <hr class="bg-dark-lighten my-3">
        <p class="mt-3 fw-semibold text-muted">Задач: <strong>18</strong> </p>
        <p class="mt-3 fw-semibold text-muted">Заседаний: <strong>18</strong> </p>
        <div class="mt-3 row d-flex justify-content-center">
            <div class="col-4 mb-3">
              <a class="btn btn-light w-100" href="{{ route ('showClientById', $el->id) }}">
              <i class="bi-three-dots"></i></a>
            </div>
        </div>
      </div>

    </div>
  </div>

@endforeach


{{-- end views for all lawyers--}}


@endsection
