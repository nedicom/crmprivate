    <div class = "row p-4">
      <div class = "col-12 ">
        <form class = "row align-items-center d-flex justify-content-between" action="{{route('clients')}}" method="GET">

          <div class="col-3 d-flex justify-content-center">
            <div class="form-check form-check-inline m-0 p-1">
              <input class="btn-check" type="radio"
              name="statustask" id="prosrochka" value="просрочена"
              @if ((app('request')->input('statustask')) == 'просрочена')checked @endif>
              <label class="btn btn-sm btn-outline-secondary" for="prosrochka">Просрочка                
                <span class="badge bg-danger">{{$dataprosr}}</span>
              </label>
            </div>
            <div class="form-check form-check-inline m-0 p-1">
              <input class="btn-check" type="radio"
              name="statustask" id="Inwork" value="в работе"
              @if ((app('request')->input('statustask')) == 'в работе')checked @endif>
              <label class="btn btn-sm btn-outline-secondary" for="Inwork">В_работе
              <span class="badge bg-success">{{$datainwork}}</span>
              </label>
            </div>
            <div class="form-check form-check-inline m-0 p-1">
              <input class="btn-check" type="radio"
              name="statustask" id="Waiting" value="ожидает"
              @if ((app('request')->input('statustask')) == 'ожидает')checked @endif>
              <label class="btn btn-sm btn-outline-secondary" for="Waiting">Ожидают
              <span class="badge bg-warning">{{$datawaiting}}</span>
              </label>
            </div>
          </div>


          <div class="col-2 d-flex justify-content-center">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox"
              id="flexSwitchCheckDefault" name="status" id="status" value="1"
              @if (app('request')->input('status') !== null) checked 
              @endif>

              <label class="form-check-label fs-6" for="flexSwitchCheckDefault">Клиент в работе</label>
            </div>
          </div>


          <div class="col-3">
          <input type = "text" name="findclient" placeholder = "введите клиента" value="@if (!empty(app('request')->input('findclient'))) {{app('request')->input('findclient')}} @endif" id="findclient" class="form-control">
          </div>

          <div class="col-2">
                <select class="form-select" name="checkedlawyer" id="checkedlawyer">
                  <option value="">все клиенты</option>
                      @foreach($datalawyers as $el)
                        <option value="{{$el -> id}}" @if (($el -> id) == (app('request')->input('checkedlawyer'))) selected @endif>
                          {{$el -> name}}
                        </option>
                      @endforeach
                </select>
          </div>

          <div class="col-2">
          <button type="submit" class="btn btn-sm btn-primary">Применить</button>
          <a href='clients' class='button btn-sm btn btn-secondary'>Сбросить</a>
          </div>


      </form>
    </div>
  </div>
