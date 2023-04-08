  @if (app('request')->input('calendar') == 'month')
    <div><span class="badge bg-primary text-truncate">{{$el -> name}}</span></div>
  @endif

  @if (app('request')->input('calendar') !== 'month')
    <div class="card border-light">
      <div class="card-body">
        <h5 class="card-title text-truncate">{{$el -> name}}</h5>
          <h5>
            <span class="badge bg-primary"> {{$el['date']['currentMonth']}}</span>
            <span class="badge bg-primary"> {{$el['date']['currentDay']}}</span>
            <span class="badge bg-success"> {{$el['date']['currentTime']}}</span>
          </h5>
          <h6>@foreach($datalawyers as $ellawyer)
              @if ($ellawyer -> id == $el -> lawyer)  {{$ellawyer -> name}} @endif
            @endforeach
          </h6>
          <p class="text-truncate">{{$el -> client}}</p>
          <div class="mt-3 row d-flex justify-content-center">
            <div class="col-4 mb-3">
              <a class="btn btn-light w-100" href="{{ route ('showMeetengById', $el->id) }}">
              <i class="bi-three-dots"></i></a>
            </div>
          </div>
      </div>
    </div>
  @endif
