@extends('layouts.app')

@section('head')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="/resources/datetimepicker/jquery.datetimepicker.css">
    <style>
      .task-toggle {
        position: absolute;
        top: 50%;
        right: 0;
        margin-top: -8px;
      }
      .task-content {
        padding: 0.4em;
      }
      .task-placeholder {
        border-left: 2px solid red;
        background-image: url('/avatars/plus.png');
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        height: 100px;
      }
      .columncard:hover{
      }
    </style>
@endsection

@section('footerscript')
    <script src="/resources/datetimepicker/jquery.datetimepicker.full.js"></script>
@endsection

@section('title')
  Задачи
@endsection

@section('leftmenuone')
    <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" id="задача" href="#" onclick="Task(this.id)" data-bs-toggle="modal" data-bs-target="#taskModal">Добавить задачу</a>
    </li>
    <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" id="консультация"  onclick="myTask(this.id)" href="#" data-bs-toggle="modal" data-bs-target="#taskModal">Добавить консультацию</a>
    </li>
    <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" id="звонок" onclick="myTask(this.id)" href="#" data-bs-toggle="modal" data-bs-target="#taskModal">Добавить звонок</a>
    </li>
    <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" id="заседание" onclick="myTask(this.id)" href="#" data-bs-toggle="modal" data-bs-target="#taskModal">Добавить заседание</a>
    </li>
    <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" id="допрос" onclick="myTask(this.id)" href="#" data-bs-toggle="modal" data-bs-target="#taskModal">Добавить допрос</a>
    </li>
@endsection

@section('main')
  <div class = "row">
      <form class = "row" action="" method="GET">
        <h2 class="col-1 px-3">Задачи</h2>
        <div class="col-12 d-flex justify-content-evenly align-items-center">
          <div class="">
            <a href="{{route('tasks')}}?checkedlawyer={{ Auth::user()->id}}" class="btn btn-outline-primary btn-sm">мои задачи</a>
          </div>

          <div class="">
            <input type="radio" class="btn-check btn-sm" value="day" name="calendar" id="day"
              @if (app('request')->input('calendar') == 'day') checked @endif
              onchange="this.form.submit()">
            <label class="btn btn-outline-success btn-sm" for="day">День</label>

            <input type="radio" class="btn-check btn-sm" value="week" name="calendar" id="week"
              @if (app('request')->input('calendar') == 'week') checked @endif
              onchange="this.form.submit()">
            <label class="btn btn-outline-success btn-sm" for="week">Неделя</label>

            <input type="radio" class="btn-check btn-sm" value="month" name="calendar" id="month"
              @if (app('request')->input('calendar') == 'month') checked @endif
              onchange="this.form.submit()">
            <label class="btn btn-outline-success btn-sm" for="month">Месяц</label>
          </div>

          @if (app('request')->input('calendar') == 'month')
              <div class="">
                  <select class="form-select" name="months" id="months">
                      <option value="0" @if (app('request')->input('months') == "0") selected @endif >январь</option>
                      <option value="1" @if (app('request')->input('months') == "1") selected @endif >февраль</option>
                      <option value="2" @if (app('request')->input('months') == "2") selected @endif >март</option>
                      <option value="3" @if (app('request')->input('months') == "3") selected @endif >апрель</option>
                      <option value="4" @if (app('request')->input('months') == "4") selected @endif >май</option>
                      <option value="5" @if (app('request')->input('months') == "5") selected @endif >июнь</option>
                      <option value="5" @if (app('request')->input('months') == "6") selected @endif >июль</option>
                      <option value="5" @if (app('request')->input('months') == "7") selected @endif >август</option>
                      <option value="5" @if (app('request')->input('months') == "8") selected @endif >сентябрь</option>
                      <option value="5" @if (app('request')->input('months') == "9") selected @endif >октябрь</option>
                      <option value="5" @if (app('request')->input('months') == "10") selected @endif >ноябрь</option>
                      <option value="5" @if (app('request')->input('months') == "11") selected @endif >декабрь</option>
                  </select>
              </div>
            @endif

            <div>
              <select class="form-select" name="checkedlawyer" id="checkedlawyer">
                <option value=''>не выбрано</option>
                    @foreach($datalawyers as $el)
                      <option value="{{$el -> id}}" @if (($el -> id) == (app('request')->input('checkedlawyer'))) selected @endif>
                        {{$el -> name}}
                      </option>
                    @endforeach
              </select>
            </div>

            <div class="">
                <select class="form-select" name="type" id="type">
                    <option value="" @if (app('request')->input('type') == "") selected @endif >все типы</option>
                    <option value="задача" @if (app('request')->input('type') == "задача") selected @endif >задача</option>
                    <option value="заседание" @if (app('request')->input('type') == "заседание") selected @endif >заседание</option>
                    <option value="допрос" @if (app('request')->input('type') == "допрос") selected @endif >допрос</option>
                    <option value="звонок" @if (app('request')->input('type') == "звонок") selected @endif >звонок</option>
                    <option value="консультация" @if (app('request')->input('type') == "консультация") selected @endif >консультация</option>
                </select>
            </div>

            <div class="">
              <button type="submit" class="btn btn-primary btn-sm">Применить</button>
              <a href='tasks' class='button btn btn-secondary btn-sm'>Сбросить</a>
            </div>
        </div>
      </form>
  </div>

  <div class="row" id="taskarea">
        @php
          $weekMap = [1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четерг', 5 => 'Пятница', 6 => 'Суббота', 7 => 'Воскресенье'];
        @endphp
        @if (app('request')->input('calendar') == '')
        <div class="row pt-4">
          <div class="col-3 columncard text-center" id="timeleft">
            <h5 class="page-title" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Сюда попадают просроченные задачи каждый день в 8.00 утра">просрочка</h5>
            @foreach($data as $el)
              @if($el -> status == "просрочена")
                @include('tasks.taskcard')
              @endif
            @endforeach
          </div>
          <div class="col-3 columncard text-center" id="waiting">
            <h5 class="page-title" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Тут задачи которые Вам поставили, но не принятые в работу">ожидает</h5>
            @foreach($data as $el)
              @if($el -> status == "ожидает")
                @include('tasks.taskcard')
              @endif
            @endforeach
          </div>
          <div class="col-3 columncard text-center" id="inwork">
            <h5 class="page-title" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Здесь задачи с которыми вы работаете сейчас. Позже будет учитываться время потраченное на выполнение">в работе</h5>
            @foreach($data as $el)
              @if($el -> status == "в работе")
                @include('tasks.taskcard')
              @endif
            @endforeach
          </div>
          <div class="col-3 columncard text-center" id="finished">
              <h5 class="page-title" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Каждый день в 00.00 выполненные задачи будут пропадать из списка">выполнена</h5>
              @foreach($data as $el)
                @if(($el -> status == "выполнена") && ($el -> donetime > Carbon\Carbon::today()))
                  @include('tasks.taskcard')
                @endif
              @endforeach
          </div>
        </div>
      @endif

      @if (app('request')->input('calendar') == 'week')
          <div class="mt-2" style="display: grid; grid-template-columns: 20% 20% 20% 20% 20%;">
            @for ($i = 1; $i < 6; $i++)
              <div class="text-center"> <h1 class="badge bg-secondary">{{$weekMap[$i]}}</h1></div>
            @endfor
              @for ($i = 1; $i < 6; $i++)
              <div class="columncard bg-white m-1" style="font-size:12px; min-height: 400px" dayofweek="{{$i}}">
                  <span class="px-2"> </span>
                  @foreach($data as $el)
                    @if($el['date']['day'] == $weekMap[$i])
                      @include('tasks.taskcard')
                    @endif
                  @endforeach
          </div>
          @endfor
      @endif

      @if (app('request')->input('calendar') == 'month')
          <div class="mt-2" style="display: grid; grid-template-columns: 14% 14% 14% 14% 14% 14% 14%;">
            @for ($i = 1; $i < 8; $i++)
            <div class="text-center">
              <h1 class="badge bg-secondary">{{$weekMap[$i]}}</h1>
            </div>
            @endfor
            @php
              $time = mktime(0, 0, 0, date('n'), 1, date('Y'));
              $firstday = (date('w', $time) + 6) % 7; //воскресенье сделаем 7-м днем, а не первым
              $daycount = date('t', $time);
            @endphp
            @for ($i = 0; $i < $firstday; $i++)
              <div class="my-3" style="min-height: 100px"></div>
            @endfor

            @for ($i = 1; $i <= (cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'))); $i++)
              <div class="columncard bg-white m-1 " style="min-height: 100px" dayofmonth="{{$i}}">
                <span class="px-2">{{$i}}</span>
                      @foreach($data as $el)
                        @if($el['date']['currentDay'] == $i)
                          @include('inc.calendar.task')
                        @endif
                    @endforeach
              </div>
            @endfor
          </div>
      @endif

      @if (app('request')->input('calendar') == 'day')
        <h2 class=""></h2>
            @for ($i = 8; $i < 22; $i++)
            <div class='row'>
              <div class='col-1 border-bottom py-1'>
                <span class="w-20  badge bg-secondary">{{$i}}.00</span>
              </div>
              <div style="min-height: 200px;" class="col-11  bg-white my-3 columncard" hourofday="{{$i}}">
              @foreach($data as $el)

                @if($el['date']['currentHour'] == $i)
                  @include('tasks.taskcard')
                @else
                <div class="taskcard inline-block"></div>
                @endif

              @endforeach
              </div>

            </div>
            @endfor
      @endif
      </div>
  {{-- end views for all meetings--}}

<script>
function mouseDown(clicked_id) {
    document.getElementById(clicked_id).style.border = "solid 1px #FF1493";
    document.getElementById('status'+clicked_id).innerHTML = "изменен";
}

function mouseUp(clicked_id) {
    document.getElementById(clicked_id).style.border = "";
}
</script>

<script>
$( document ).ready(function() {
$( function() {
    $( ".columncard" ).sortable({
      connectWith: ".columncard",
      handle: ".card",
      cancel: ".task-toggle",
      placeholder: "task-placeholder ui-corner-all",
      opacity: 0.5,
      receive: function(event, ui) {
        var id =  ui.item.attr("id");

        if(this.id){var status =  this.id;}
        else{var status = 0;};

        $input = $( this );
        if($input.attr( "dayofweek" )){var dayofweek =  $input.attr( "dayofweek" );}
        else{var dayofweek = 0;};
        if(ui.item.attr("date")){var date =  ui.item.attr("date");}
        else{var date = 0;};
        if($input.attr("hourofday")){var hourofday =  $input.attr("hourofday");}
        else{var hourofday = 0;};
        if($input.attr( "dayofmonth" )){var dayofmonth =  $input.attr( "dayofmonth" );}
        else{var dayofmonth = 0;};

        $.ajax({
          method:"POST",
          url: "{{ route('setstatus') }}",
          data: { id: id, status: status, date: date, hourofday: hourofday, dayofweek: dayofweek, dayofmonth: dayofmonth, _token: '{{csrf_token()}}' },
          success: function(data) {
          }
        });
      }
    });

    $( ".taskcard" )
      .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
      .find( ".task-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-minusthick task-toggle'></span>");

    $( ".task-toggle" ).on( "click", function() {
      var icon = $( this );
      icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
      icon.closest( ".taskcard" ).find( ".task-content" ).toggle();
    });
  });
});
</script>


<script>
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
return new bootstrap.Popover(popoverTriggerEl)
})

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

    <script>
$( document ).ready(function() {
    $( ".changetags" ).click(function() {
            var $input = $( this );
            var id =  $input.attr( "tagName" )
            var color =  $input.attr( "color" )
            var value =  this.value;
            $('#tagspan'+id).css("color", color);
            $.ajax({
                url:"{{ route('tag') }}",
                method:"POST",
                data: { id: id, value: value, _token: '{{csrf_token()}}' },
                  success:function(data){
                  }
            });
      });
    });
    </script>

<script>
  function myTask(clicked_id) {
    var type = clicked_id;
    document.getElementById("taskname").innerHTML = type;
    document.getElementById("nameoftask").value = type;
    document.getElementById("duration").value = 1;
    var collection = document.getElementsByClassName("hideme")
      for (let i = 0; i < collection.length; i++) {
        collection[i].style.display = "none";
      }
    document.getElementById("type").value = type;
    document.getElementById("lawyer").value = {{ Auth::user()->id}};
    document.getElementById("soispolintel").value = {{ Auth::user()->id}};
    var now = new Date();
    now.setHours(23);
    now.setMinutes(00);
    document.getElementById("date").value = now.toISOString().slice(0,16);
  }
</script>

<script>
  function Task(clicked_id) {
    var type = clicked_id;
    document.getElementById("taskname").innerHTML = type;
    document.getElementById("nameoftask").value = '';
    document.getElementById("duration").value = 1;
    var collection = document.getElementsByClassName("hideme")
      for (let i = 0; i < collection.length; i++) {
        collection[i].style.display = "block";
      }
    document.getElementById("type").value = type;
    document.getElementById("lawyer").value = {{ Auth::user()->id}};
    document.getElementById("soispolintel").value = {{ Auth::user()->id}};
    var now = new Date();
    now.setHours(23);
    now.setMinutes(00);
    document.getElementById("date").value = now.toISOString().slice(0,16);
  }
</script>

@include('inc/modal/addtask')
@include('inc/modal/addtypetask')

@endsection
