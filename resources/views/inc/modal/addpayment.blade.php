  <script>
    $(document).ready(function(){

     $('#client').keyup(function(){
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

        $(document).on('click', '.clientList', function(){
          $('#clientidinput').val($(this).val());
          $('#client').val($(this).attr( "name" ));
          $('#clientList').fadeOut();
        });

    });
  </script>

  {{-- end ajax payments--}}


  <div class="modal fade" id="paymentModal">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class ="modal-header">
            <h2>Добавить платеж</h2>
          </div>

          <div class ="modal-body d-flex justify-content-center">

          <div class ="col-10">
            <form action="{{route('addpayment')}}" class='' autocomplete="off" method="post">
              @csrf


              <label for="summ" class="form-label">Введите сумму</label>
              <div class = "row d-flex align-items-center mb-3">              
                <div class = "col-6">
                  <div class="input-group d-flex align-items-center">
                      <span class="input-group-text">ru</span>
                        <input type = "number" name="summ" placeholder="" value="{{ old('summ') }}" id="summ" class="form-control" value='' required
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
                        <input type = "number" name="sellsumm" placeholder="" value="{{ old('sellsumm') }}" 
                        style="input::-webkit-inner-spin-button: -webkit-appearance: none; margin: 0; -moz-appearance: textfield;"
                        id="sellsumm" class="form-control" value=''>
                      <span class="input-group-text">.00</span>
                  </div>
                </div>
                <div class = "col-6 d-flex align-items-center">
                  <span class="">За сколько продана услуга?</span>
                </div>
              </div>

              <div class="form-group mb-3">
                <label for="client">Укажите клиента</label>
                <input type = "text" name="client" id="client" class="form-control">
                <div id="clientList">
                </div>
              </div>

              <div class="form-group mb-3">
                <label for="service">Укажите услугу</label>
                <select class="form-select" name="service" id="service" class="form-control">
                      @foreach($dataservices as $el)
                        <option value="{{$el -> id}}">{{$el -> name}} ({{$el -> price}})</option>
                      @endforeach
                </select>
              </div>

              <div class="form-group mb-3">
                <label for="nameOfAttractioner">Укажите кто привлек клиента</label>
                <select class="form-select" name="nameOfAttractioner" id="nameOfAttractioner" class="form-control">
                      @foreach($datalawyers as $el)
                        <option value="{{$el -> id}}">{{$el -> name}}</option>
                      @endforeach
                </select>
              </div>


              <div class="form-group mb-3">
                <label for="nameOfSeller">Укажите кто продал услугу</label>
                <select class="form-select" name="nameOfSeller" id="nameOfSeller" class="form-control">
                      @foreach($datalawyers as $el)
                        <option value="{{$el -> id}}">{{$el -> name}}</option>
                      @endforeach
                </select>
              </div>

              <div class="form-group mb-3">
                <label for="directionDevelopment">Укажите кто развивал направление</label>
                <select class="form-select" name="directionDevelopment" id="directionDevelopment" class="form-control">
                      @foreach($datalawyers as $el)
                        <option value="{{$el -> id}}">{{$el -> name}}</option>
                      @endforeach
                </select>
              </div>

              <div class="form-group mb-3">
                <label for="calculation">Куда поступили деньги</label>
                <select class="form-select" name="calculation" id="calculation" aria-label="Default select example">
                  <option value="РНКБ" selected>РНКБ</option>
                  <option value="СБЕР">СБЕР</option>
                  <option value="ГЕНБАНК">ГЕНБАНК</option>
                  <option value="НАЛИЧНЫЕ">НАЛИЧНЫЕ</option>
                </select>
              </div>

              <input type="hidden" name="clientidinput" id="clientidinput" class="form-control">

              <button type="submit" id='submit' class="btn btn-primary">Сохранить</button>
            </form>
          </div>
        </div>

        </div>
      </div>
    </div>

    <script>
    $("#predoplata").change(function() {
          if(this.checked) {
            $( "#predoplatadiv" ).fadeIn("slow");
          }
          else{
            $( "#predoplatadiv" ).fadeOut("slow");         
          }
    });

    </script>