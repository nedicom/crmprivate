<script>
$(document).ready(function(){
    $('#client').keyup(function() {
        var query = $(this).val();
        var quantity = $(this).val().length;

        if(quantity > 2)
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('getclient') }}",
                method:"POST",
                data:{query:query, _token:_token},
                success:function(data){
                    $('#clientList').fadeIn();
                    $('#clientList').html(data);
                }
            });
        }
    });
    $(document).on('click', '.clientAJAX', function() {
        $('#clientidinput').val($(this).val());
        $('#client').val($(this).text());
        $('#clientList').fadeOut();
    });
});

// Datepicker
$(document).ready(function() {
    $('input#date').datetimepicker({
        lang: 'ru',
        step: 5,
    });
});
</script>

<div class="modal fade" id="edittaskModal">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class ="modal-header">
                <h2>Изменить задачу</h2>
            </div>
            <div class ="modal-body d-flex justify-content-center">
                <div class ="col-10">
                    <form action="{{route('editTaskById', $data -> id)}}" autocomplete="off" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nameoftask">Укажите название<span class="text-danger">*</span></label>
                            <input type = "text" name="nameoftask" placeholder="" id="nameoftask" value="{{$data->name}}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Описание</label>
                            <textarea rows="3" name="description" placeholder="Немного подробнее о задаче (необязательно)" id="description" class="form-control">{{$data->description}}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-4 form-group mb-3">
                                <label for="date">Время начала:<span class="text-danger">*</span></label>
                                <input type="text" id="date" value="{{$data->date['value']}}" class="form-control" name="date">
                            </div>
                            <div class="col-4 form-group mb-3">
                                <span>Продолжительность<span class="text-danger">*</span></span>
                                <div class="input-group form-group mb-3">
                                    <label class="input-group-text" for="duration"><i class="bi bi-stopwatch"></i></label>
                                    <input type = "number" name="duration" value="{{$data->duration}}" min="0.5" max="25" step="0.5" id="duration" class="form-control">
                                    <span class="input-group-text">час</span>
                                </div>
                            </div>
                            <div class="col-4 form-group mb-3">
                                <label for="name">Яндекс-диск</label>
                                <input type = "url" name="hrftodcm" placeholder="https://disk.yandex.ru" id="hrftodcm"
                                    value="{{$data->hrftodcm}}" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group mb-3">
                                <label for="client">Клиент<span class="text-danger">*</span></label>
                                <input type = "text" name="client" id="client" value="{{$data->client}}" class="form-control">
                                <div id="clientList">
                                </div>
                            </div>
                            <div class="col-3 form-group mb-3">
                                <label for="tag">Отметка</label>
                                <select class="form-select" name="tag" id="tag">
                                    <option value="неважно"  @if ($data->tag == "в работе") selected @endif>неважно</option>
                                    <option value="перенос"  @if ($data->tag == "перенос") selected @endif>перенос</option>
                                    <option value="срочно"  @if ($data->tag == "срочно") selected @endif>срочно</option>
                                    <option value="приоритет"  @if ($data->tag == "приоритет") selected @endif>приоритет</option>
                                </select>
                            </div>
                            <div class="col-3 form-group mb-3">
                                <label for="status">Cтатус</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="в работе"  @if ($data->status == "в работе") selected @endif>в работе</option>
                                    <option value="просрочена" @if ($data->status == "просрочена") selected @endif>просрочена</option>
                                    <option value="выполнена"  @if ($data->status == "выполнена") selected @endif>выполнена</option>
                                    <option value="ожидает"  @if ($data->status == "ожидает") selected @endif>ожидает</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 form-group mb-3">
                                <label for="lawyer">Исполнитель<span class="text-danger">*</span></label>
                                <select class="form-select" name="lawyer" id="lawyer" class="form-control">
                                    @foreach($datalawyers as $el)
                                        <option value="{{$el -> id}}"  @if ($data->lawyer == $el -> id) selected @endif>{{$el -> name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 form-group mb-3">
                                <label for="soispolintel">соИсполнитель</label>
                                <select class="form-select" name="soispolintel" id="soispolintel" class="form-control">
                                    @foreach($datalawyers as $el)
                                        <option value="{{$el -> id}}" @if ($data->soispolintel == $el -> id) selected @endif>{{$el -> name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 form-group mb-3">
                                <label for="type">Тип</label>
                                <select class="form-select" name="type" id="type">
                                    <option value="задача" @if ($data->type == "задача") selected @endif >задача</option>
                                    <option value="заседание" @if ($data->type == "заседание") selected @endif >заседание</option>
                                    <option value="допрос" @if ($data->type == "допрос") selected @endif >допрос</option>
                                    <option value="звонок" @if ($data->type == "звонок") selected @endif >звонок</option>
                                    <option value="консультация" @if ($data->type == "консультация") selected @endif >консультация</option>
                                </select>
                            </div>
                        </div>
                        <!-- Список дел -->
                        <div class="list-deals-block"></div>

                        <input type="hidden" name="clientidinput" id="clientidinput" class="form-control">
                        <button type="submit" id='submit' class="btn btn-primary">обновить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
