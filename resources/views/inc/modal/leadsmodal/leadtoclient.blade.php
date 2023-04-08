  <div class="modal fade" id="modalleadtoclient">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class ="modal-header">
            <h2>Перевести в клиента</h2>
          </div>

          <div class ="modal-body d-flex justify-content-center">

          <div class ="col-10">
            <form action="{{route('leadToClient', $data -> id)}}" class='' autocomplete="off" method="post">
              @csrf

              <div class="form-group mb-3">
                <label for="successreason">Причина успеха</label>
                <textarea rows="3" name="successreason"
                placeholder="Что, по Вашему мнению, способствовало успешной работе с лидом" id="successreason" class="form-control" required>{{$data->successreason}}</textarea>
              </div>

              <button type="submit" id='submit' class="btn btn-primary">Сохранить</button>
            </form>
          </div>
        </div>

        </div>
      </div>
    </div>
