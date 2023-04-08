  @extends('layouts.app')


  @section('title')
    услуги
  @endsection

    @section('leftmenuone')
      <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#serviceModal">Добавить услугу</a>
      </li>
    @endsection

@section('main')
    <h2 class="px-3">Услуги</h2>

    {{-- start views for all services--}}

        <div class="col-12">
        </div>



          @foreach($data as $el)
        <div class="col-3 my-3">
          <div class="card border-light">
              <div class="card-body">
                <h5 class="card-title">{{$el -> name}}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{$el -> price}}</h6>
                  <h4 class="header-title mb-3"></h4>

                   <span class="badge bg-success"> +5.35% </span>

                  <p>{{$el -> created_at}}</p>


                  <div class="mt-3 row d-flex justify-content-center">
                          <div class="col-4 mb-3">
                            <a class="btn btn-light w-100" href="#">
                            <i class="bi-three-dots"></i></a>
                          </div>
                  </div>
                </div>
              </div>
          </div>




          @endforeach


    {{-- end views for all services--}}

@endsection
