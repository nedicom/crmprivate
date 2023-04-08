  <div class="modal fade" id="modalleadtowork">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class ="modal-header">
            <h2>Взять в работу</h2>
          </div>

          <div class ="modal-body d-flex justify-content-center">

          <div class ="col-10">
            <form action="{{route('leadToWork', $data -> id)}}" class='' autocomplete="off" method="post">
              @csrf

              <div class="form-group mb-3">
                <label for="action">Что делаем с лидом</label>
                <textarea rows="3" name="action"
                placeholder="например, позвонить во вторник/провести консультацию в четверг" id="action" class="form-control" required>{{$data->action}}</textarea>
              </div>

              <button type="submit" id='submit' class="btn btn-primary">Сохранить</button>
            </form>
          </div>
        </div>

        </div>
      </div>
    </div>
