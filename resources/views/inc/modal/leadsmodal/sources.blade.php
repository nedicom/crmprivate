  <div class="modal fade" id="SourcesModal">
    <div class="modal-dialog">
      <div class="modal-content ">
          <div class ="modal-header">
            <h3>источники лидов</h3>
          </div>

          <div class ="modal-body d-flex justify-content-center">

          <div class ="col-10">
            <form action="{{route('addSource')}}" class='' autocomplete="off" method="post">
              @csrf

          <div class ="mt-1">
          <h5 class ="my-2">существующие источники</h6>
              @foreach ($datasources as $name)
                  @php
                  $input = ["primary", "secondary", "danger", "success", "info", "dark"];
                  $rand_key =rand(0, 4);
                  @endphp
                <span class="badge bg-{{$input[$rand_key]}} shadow m-1">{{$name -> name}}</span>
              @endforeach
          </div>

              <div class="form-group mb-3">
              <h5 class ="mt-5">добавить новый</h6>
                <label for="sourcename">Введите название нового источника Лидов</label>
                <input type = "text" name="sourcename" id="sourcename" class="form-control"
                required aria-describedby="helpsourceform">
                <div id="helpsourceform" class="form-text">
                  Убедитесь, что Вы не дублируете существующий источник
                </div>
              </div>

              <button type="submit" id='submit' class="btn btn-primary">Сохранить</button>
            </form>
          </div>
        </div>

        </div>
      </div>
    </div>
