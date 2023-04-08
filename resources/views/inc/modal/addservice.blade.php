  <div class="modal fade" id="serviceModal">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class ="modal-header">
            <h2>Добавить услугу</h2>
          </div>

          <div class ="modal-body d-flex justify-content-center">

          <div class ="col-10">
            <form action="{{route('addservice')}}" autocomplete="off" method="post">
              @csrf

              <label for="price" class="form-label">Введите стоимость</label>
              <div class="input-group mb-3">
                    <span class="input-group-text">ru</span>
                      <input type = "number" name="price" id="price" class="form-control" required>
                    <span class="input-group-text">.00</span>
                </div>

              <div class="form-group mb-3">
                <label for="name">Укажите название</label>
                <input type = "text" name="name" placeholder="" id="name" class="form-control" required>
              </div>

              <button type="submit" id='submit' class="btn btn-primary">Сохранить</button>
            </form>
          </div>
        </div>

        </div>
      </div>
    </div>
