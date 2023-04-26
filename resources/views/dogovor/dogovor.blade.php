@extends('layouts.app')

@section('title') договоры @endsection

@section('leftmenuone')
    <li class="nav-item text-center p-3">
        <a class="text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#dogovorModal">Добавить договор</a>
    </li>
@endsection

@section('main')
    <h2 class="px-3">Договоры</h2>

    <div class="col-12"></div>
    @foreach ($data as $el)
        <div class="col-3 my-3">
            <div class="card shadow">
                <div class="card-header d-flex align-items-center">
                    <span>
                       @foreach ($datalawyers as $ellawyer)
                           @if ($ellawyer->id == $el->lawyer_id)
                                <img src="{{$ellawyer->avatar}}" style="width: 40px; height:40px" class="rounded-circle">
                           @endif
                       @endforeach
                    </span>
                    <span class="mx-3 text-truncate">{{$el->name}}</span>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h2 class="px-2 text-truncate text-center" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" title="предмет" data-bs-content="{{$el->subject}}"><strong>{{$el->allstoimost}}</strong></h2>
                    </div>
                    <p class="px-2">{{$el->created_at}}</p>
                    <div class="d-flex align-items-center">
                        <span class="px-2 text-truncate text-center">
                          @foreach ($dataclients as $elclient)
                                @if ($elclient->id == $el->client_id)
                                    {{$elclient->name}}
                                @endif
                            @endforeach
                        </span>
                        @if ($el->url)<a href="/{{$el->url}}" class="btn btn-primary">скачать</a>@else <a href="#" class="btn btn-secondary disabled">скачать</a>@endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    @include('inc./modal/adddogovor')
@endsection
