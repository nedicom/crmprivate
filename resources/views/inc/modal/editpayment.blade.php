<div class="modal fade" id="editpaymentModal">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class ="modal-header">
          <h2>Редактировать платеж</h2>
        </div>

        <div class ="modal-body">
        <form action="{{route('PaymentUpdateSubmit', $data -> id)}}" method="post" autocomplete="off">
        @csrf
        

        <label for="summ" class="form-label">Введите сумму</label>
              <div class = "row d-flex align-items-center mb-3">              
                <div class = "col-6">
                  <div class="input-group d-flex align-items-center">
                      <span class="input-group-text">ru</span>
                        <input type = "number" name="summ" placeholder="" value="{{$data->summ}}" id="summ" class="form-control" required
                        style="input::-webkit-inner-spin-button: -webkit-appearance: none; margin: 0; -moz-appearance: textfield;"
                        >
                      <span class="input-group-text">.00</span>
                  </div>
                </div>
                <div class="form-check col-6">
                  <input class="form-check-input" type="checkbox" value="predoplata" id="predoplata"
                  data-bs-toggle="collapse" href="#predoplatadiv" aria-expanded="false" aria-controls="predoplatadiv">
                  <label class="form-check-label" for="predoplata">
                    Частичный платеж
                  </label>
                </div>
              </div>

              <div class = "row mb-3 collapse" id="predoplatadiv">              
                <div class = "col-6">
                  <div class="input-group">
                      <span class="input-group-text">ru</span>
                        <input type = "number" name="sellsumm" placeholder="" value="{{$data->predoplatasumm}}" 
                        style="input::-webkit-inner-spin-button: -webkit-appearance: none; margin: 0; -moz-appearance: textfield;"
                        id="sellsumm" class="form-control">
                      <span class="input-group-text">.00</span>
                  </div>
                </div>
                <div class = "col-6 d-flex align-items-center">
                  <span class="">За сколько продана услуга?</span>
                </div>
              </div>


        <div class="form-group mb-3">
          <label for="client">Клиент не редактируется</label>
          <input type = "text" name="client" value='{{$data->client}}' readonly class="form-control-plaintext">          
        </div>
        <input type = "text" name="clienthidden" value='{{$data->clientid}}' class="invisible">

        <div class="form-group mb-3">
          <label for="service">Укажите услугу</label>
          <select class="form-select" name="service" id="service" class="form-control">
                @foreach($dataservices as $el)
                  <option value="{{$el -> id}}" @if ($data->service == $el -> id) selected @endif>{{$el -> name}} ({{$el -> price}})</option>
                @endforeach
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="nameOfAttractioner">Укажите кто привлек клиента</label>
          <select class="form-select" name="nameOfAttractioner" id="nameOfAttractioner" class="form-control">
                @foreach($datalawyers as $el)
                  <option value="{{$el -> id}}" @if ($data->nameOfAttractioner == $el -> id) selected @endif>{{$el -> name}}</option>
                @endforeach
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="nameOfSeller">Укажите кто продал услугу</label>
          <select class="form-select" name="nameOfSeller" id="nameOfSeller" class="form-control">
                @foreach($datalawyers as $el)
                  <option value="{{$el -> id}}"  @if ($data->nameOfSeller == $el -> id) selected @endif>{{$el -> name}}</option>
                @endforeach
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="directionDevelopment">Укажите кто развивал направление</label>
          <select class="form-select" name="directionDevelopment" id="directionDevelopment" class="form-control">
                @foreach($datalawyers as $el)
                  <option value="{{$el -> id}}"  @if ($data->directionDevelopment == $el -> id) selected @endif>{{$el -> name}}</option>
                @endforeach
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="calculation">Куда поступили деньги</label>
          <select class="form-select" name="calculation" id="calculation" aria-label="Default select example">
            <option value="РНКБ" @if ($data->calculation == "РНКБ") selected @endif>РНКБ</option>
            <option value="СБЕР" @if ($data->calculation == "СБЕР") selected @endif>СБЕР</option>
            <option value="ГЕНБАНК" @if ($data->calculation == "ГЕНБАНК") selected @endif>ГЕНБАНК</option>
            <option value="НАЛИЧНЫЕ" @if ($data->calculation == "НАЛИЧНЫЕ") selected @endif>НАЛИЧНЫЕ</option>
          </select>
        </div>

        <button type="submit" id='submit' class="btn btn-primary">Обновить</button>
      </form>
    </div>

    </div>
  </div>
</div>