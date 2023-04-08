@extends('layouts.app')

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

@section('title')
  Все клиенты
@endsection

@section('leftmenuone')
  <li class="nav-item text-center p-3">
    <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#myModal">Добавить клиента</a>
  </li>
@endsection

@section('main')
    <h2 class="px-3">Клиенты ({{$data->count()}})</h2>

    @include('inc/filter.clientfilter')

    <div class = "row p-4">

    @foreach($data as $el)

      <div class= 'card row my-3 p-3 border'>
        <div class="text-center d-inline-flex justify-content-between align-items-center">

        <div class="col-4">
            <div class="col-6 d-flex justify-content-center">
                  <div class="px-1 col-4">
                    <a class="btn btn-light w-100" href="{{ route ('showClientById', $el->id) }}">
                    <i class="bi-three-dots"></i></a>
                  </div>
                  <div class="px-1 col-4">
                    <a class="btn btn-light w-100 nameToForm" href="#"
                    dataclient="{{$el -> name}}" datavalueid="{{$el -> id}}" data-bs-toggle="modal" data-bs-target="#taskModal">
                    <i class="bi-clipboard-plus"></i></a>
                  </div>
                  <div class="px-1 col-4">
                  <img src="@if($el -> userFunc -> avatar){{$el -> userFunc -> avatar}}@endif" style="width: 30px;  height:30px"
                  class="rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                  title="@if($el -> userFunc -> name){{$el -> userFunc -> name}}@endif">
                </div>
            </div>
          </div>
            <div class="col-4 text-muted text-truncate fw-bold">{{$el -> name}}</div>

          <div class="col-4 d-flex align-items-center justify-content-end">
            <div class="col-6 d-flex align-items-cente justify-content-end">
              <div>
                <p class="mb-0 text-muted">{{$el -> phone}}</p>
                <p class="mb-0 text-muted">{{$el -> email}}</p>
              </div>
            </div>

            <div class="col-6 d-flex align-items-center justify-content-end">
              <div  class="px-3">
                @if ($el -> status == 1)
                    <i class="bi bi-person" style = "font-size: 2rem; color: #0acf97;"></i>
                @else
                    <i class="bi bi-person" style = "font-size: 2rem; color: gray;"></i>
                @endif
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="d-flex flex-wrap">
            @foreach($el -> tasksFunc as $val)
              @if($val -> status !== 'выполнена')
              <div class="col-2 px-3 py-3 border border-4 border-light" style="background-color:
                @if($val -> status == 'просрочена') LightCoral
                @elseif($val -> status == 'в работе') MediumAquaMarine
                @elseif($val -> status == 'ожидает') Cornsilk
                @else Cornsilk  @endif
              ;">
                <div class="d-flex justify-content-between bg-white px-2 pt-1">
                  <span class="fw-normal" style="font-size: 14px;!important" title="{{ $val -> status }}">{{$val -> date['value']}}</span>
                  @if($val -> type == 'консультация')
                  <i class="bi bi-chat-dots"  data-bs-toggle="tooltip" data-bs-placement="top" title="это консультация"></i>
                  @elseif($val -> type == 'заседание')
                  <i class="bi bi bi-briefcase"  data-bs-toggle="tooltip" data-bs-placement="top" title="это заседание"></i>
                  @elseif($val -> type == 'допрос')
                  <i class="bi bi bi-emoji-neutral"  data-bs-toggle="tooltip" data-bs-placement="top" title="это допрос"></i>
                  @elseif($val -> type == 'звонок')
                  <i class="bi bi-phone"  data-bs-toggle="tooltip" data-bs-placement="top" title="это звонок"></i>
                  @else
                  <i class="bi bi-clipboard"  data-bs-toggle="tooltip" data-bs-placement="top" title="это обычная задача"></i>
                  @endif
                  <input class="form-check-input checkedvipolnena" autocomplete="off" type="checkbox" value="" id="{{$val -> id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="выполнена">
                </div>
                  <div class="px-1 fw-normal bg-white border border-white"  style="height: 80px; overflow: hidden; position: relative;">
                    <a href="/tasks/{{$val -> id}}" style="font-size: 14px;!important" target="_blank">{{$val -> name}}</a>
                  </div>
              </div>
              @endif
            @endforeach
              <div class="col-2 px-3 py-3 border border-4 border-light" style="background-color: Cornsilk;;">
                  <span class="px-1 fw-normal bg-white border border-white" style="font-size: 14px;!important">добавить</span>
                  <div class="px-1 fw-normal bg-white border border-white d-flex flex-wrap"  style="height: 80px; overflow: hidden; position: relative;">
                    <div><a class="btn w-100 nameToForm" id="задача" onclick="Task(this.id)" href="#"
                    dataclient="{{$el -> name}}" datavalueid="{{$el -> id}}" data-bs-toggle="modal" data-bs-target="#taskModal"
                   target="_blank">
                    <i class="bi-clipboard-plus"></i></a></div>
                    <div><a class="btn w-100 nameToForm" id="звонок" onclick="myTask(this.id)" href="#"
                    dataclient="{{$el -> name}}" datavalueid="{{$el -> id}}" data-bs-toggle="modal" data-bs-target="#taskModal"
                   target="_blank">
                    <i class="bi bi-phone"></i></a></div>
                    <div><a class="btn w-100 nameToForm" id="консультация" onclick="myTask(this.id)" href="#"
                    dataclient="{{$el -> name}}" datavalueid="{{$el -> id}}" data-bs-toggle="modal" data-bs-target="#taskModal"
                   target="_blank">
                    <i class="bi bi-chat-dots"></i></a></div>
                    <div><a class="btn w-100 nameToForm" id="заседание" onclick="myTask(this.id)" href="#"
                    dataclient="{{$el -> name}}" datavalueid="{{$el -> id}}" data-bs-toggle="modal" data-bs-target="#taskModal"
                   target="_blank">
                    <i class="bi bi-briefcase"></i></a></div>
                    <div><a class="btn w-100 nameToForm" id="допрос" onclick="myTask(this.id)" href="#"
                    dataclient="{{$el -> name}}" datavalueid="{{$el -> id}}" data-bs-toggle="modal" data-bs-target="#taskModal"
                   target="_blank">
                    <i class="bi bi-emoji-neutral"></i></a></div>
                  </div>
              </div>
          </div>
        </div>
      </div>
    @endforeach

    </div>

    </div>

    <div class="toast-container position-fixed my-2 top-0 start-50 translate-middle-x" aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast">
        <div class="toast-header d-flex justify-content-between">
          <strong class="mr-auto">Сообщение</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
        </div>
        <div class="toast-body" id="toast-body">
            Все в порядке, клиент добавлен
        </div>
      </div>
    </div>

    @include('inc./modal/addclient')
    @include('inc/modal/addtask')
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
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

    <script>
      $( document ).ready(function() {
        $(".checkedvipolnena").click(function(){
                var id =  this.id;
                var checkedvipolnena = this.checked;

                $.ajax({
                  method:"POST",
                  url: "{{ route('setstatus') }}",
                  data: { id: id, checkedvipolnena: checkedvipolnena, _token: '{{csrf_token()}}' },
                  success: function(data) {
                    var toast = document.getElementById('toast');
                    var toastbody = document.getElementById('toast-body');
                      if(data=="true"){
                      $( toast ).addClass( "show");
                      $( toastbody ).html("Выполнена!");
                        setTimeout(function() {
                            $(toast).removeClass('show');
                        }, 1000)
                      }
                      if(data=="false"){
                      $( toast ).addClass( "show");
                      $( toastbody ).html("Ожидает!");
                        setTimeout(function() {
                            $(toast).removeClass('show');
                        }, 1000)
                      }
                  }
                });
        });
       });
    </script>
@endsection
