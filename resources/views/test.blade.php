  @extends('layouts.app')


  @section('title')
    test
  @endsection

    @section('leftmenuone')
      <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#">test</a>
      </li>
    @endsection

@section('main')

        <td>{{$data}}</td>


@endsection
