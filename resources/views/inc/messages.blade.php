@if($errors->any())
    <div class = "toast-container position-fixed m-2 top-0 end-0" aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header d-flex justify-content-between">
                <strong class="mr-auto">Сообщение</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
            </div>
            <div class="toast-body">
                @foreach($errors->all() as $error)
                    {{$error}}</br>
                @endforeach
            </div>
        </div>
    </div>
@endif

@if(session('success'))
    <div class = "toast-container position-fixed my-2 top-0 start-50 translate-middle-x" aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header d-flex justify-content-between">
                <strong class="mr-auto">Сообщение</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
            </div>
            <div class="toast-body">
                {{session('success')}}
                @if(session('url') && is_string(session('url')))
                    <a href="{{session('url')}}">Скачать договор</a>
                @endif
            </div>
        </div>
    </div>
@endif
