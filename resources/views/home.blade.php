@extends('layouts.app')

@section('head')
    <script src="https://kit.fontawesome.com/dd594527e8.js" crossorigin="anonymous"></script>
@endsection

@section('title')
    Главная
@endsection

@section('leftmenuone')
    <form action="{{route('home')}}" class="my-3" method="GET" id="form-filter">
        <div class="d-inline-flex flex-column px-3 m-1 mb-3">
            <div class="form-check">
                <input class="btn-check input-home-filter" type="radio" name="date" id="day" value="day" @if ('day' == (request()->get('date'))) checked @endif>
                <label class="btn btn-light" for="day">День</label>
                <input class="btn-check input-home-filter" type="radio" name="date" id="month" value="month" @if ('month' == (request()->get('date'))) checked @endif>
                <label class="btn btn-light" for="month">Месяц</label>
            </div>
        </div>
        @if (auth()->user()->isAdmin())
            <div class="px-3 m-1">
                <select class="form-select form-select-sm input-home-filter" name="lawyer">
                    <option value="">юрист</option>
                    @foreach($data['datalawyers'] as $el)
                        <option value="{{$el->id}}" @if ($el->id == (request()->get('lawyer'))) selected @endif>{{$el->name}}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </form>
@endsection

@section('main')
    <div class="row">
        <h3 class="px-3 col-8 pb-3">Показатели <small class="text-muted">@if ('day' == (request()->get('date'))) сегодня @else месяц @endif</small></h3>
        <div class="col-4">
            <div class="mb-2">
                @if($user->tg_id)
                    <a href="{{ config('app.bot_staff.link') }}?start={{ base64_encode($user->id) }}">Бот-информер подключен</a>.
                @else
                    Для подключения бота-инфомера к своему аккаунту
                    <a href="{{ config('app.bot_staff.link') }}?start={{ base64_encode($user->id) }}">перейдите по ссылке</a>.
                @endif
            </div>
            <form enctype="multipart/form-data" action="{{ route('add-avatar') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-8">
                        <input class="form-control" type="file" id="avatar" name="avatar" accept=".png, .jpg, .jpeg" required>
                    </div>
                    <div class="col-4">
                        <input type="submit" value="сменить аватар" class="btn btn-secondary">
                    </div>
                </div>
            </form>
            <div class="pt-2">
                <!-- The button used to copy the text -->
                <label  for="calendarurl" class="visually-hidden"  >Копировать ссылку</label>
                <!-- The text field -->
                <div class="input-group">
                    <div class="input-group-text" id="btnurl">копировать ссылку</div>
                    <input class="form-control" type="text" value="https://crm.nedicom.ru/calendar/{{auth()->user()->id}}" id="calendarurl">
                </div>
            </div>
        </div>
    </div>
    <div class = "row">
        @if (!config('app.debug'))
            <div class = "row mt-2 h-25" >
                <iframe src="https://datalens.yandex/gwhlvrc5b8es6"></iframe>
            </div>
        @endif

        <div class = "row mt-2">
            <div class = "col-4">
                <div class = "card border-light">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between">
                            <div>Задачи поставлены</div>
                            <div><i class="fa-solid fa-list-check"></i></div>
                        </h5>
                        @if(count($all['alltasks']) == 0)
                            <h1 class="card-text">0
                            </h1>
                        @endif
                        <table class="table table-sm">
                            <tbody>
                            @foreach($all['alltasks'] as $el)
                                <tr class="my-3"><td><a href="tasks/{{$el->id}}" class="text-decoration-none" target="_blank">{{$el->name}}</a></td><td>{{$el->client}}</td></tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "col-4"></div>
            <div class = "col-4">
                <div class = "card border-light">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between">
                            <div>Задачи просрочены</div>
                            <div><i class="fa-sharp fa-solid fa-exclamation"></i></div>
                        </h5>
                        @if(count($all['alltaskstime']) == 0)
                            <h1 class="card-text">0
                            </h1>
                        @endif
                        <table class="table table-sm">
                            <tbody>
                            @foreach($all['alltaskstime'] as $el)
                                <tr class="my-3">
                                    <td><a href="tasks/{{$el->id}}" class="text-decoration-none" target="_blank">{{$el->name}}</a></td><td>{{$el["date"]["value"]}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "row  mt-2">
                <div class = "col-4">
                    <div class = "card border-light">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between">
                                <div>Новые задачи</div>
                                <div><i class="fa-sharp fa-regular fa-circle"  style="--fa-primary-color: dodgerblue;"></i></div>
                            </h5>
                            @if(count($all['alltasksnew']) == 0)
                                <h1 class="card-text">0
                                </h1>
                            @endif
                            <table class="table table-sm">
                                <tbody>
                                @foreach($all['alltasksnew'] as $el)
                                    <tr class="my-3"><td><a href="tasks/{{$el->id}}" class="text-decoration-none" target="_blank">{{$el->name}}</a></td><td>{{$el->client}}</td></tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class = "col-4">
                    <div class = "card border-light">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between">
                                <div>Задачи</div>
                                <div><i class="fa-sharp fa-solid fa-calendar-day"></i></div>
                            </h5>
                            @if(count($all['alltaskstoday']) == 0)
                                <h1 class="card-text">0
                                </h1>
                            @endif
                            <table class="table table-sm">
                                <tbody>
                                @foreach($all['alltaskstoday'] as $el)
                                    <tr class="my-3">
                                        <td><a href="tasks/{{$el->id}}" class="text-decoration-none" target="_blank">{{$el->name}}</a></td><td>{{$el->client}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class = "col-4"></div>
                <div class = "row">
                    <div class = "col-4">
                        <div class = "card border-light">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <div>Клиенты</div>
                                    <div><i class="fa-sharp fa-solid fa-person"></i></div>
                                </h5>
                                @if(count($all['allclients']) == 0)
                                    <h1 class="card-text">0
                                    </h1>
                                @endif
                                <table class="table table-sm">
                                    <tbody>
                                    @foreach($all['allclients'] as $el)
                                        <tr class="my-3"><td><a href="clients/{{$el->id}}" class="text-decoration-none" target="_blank">{{$el->name}}</a></td><td>{{$el->phone}}</td><td>{{$el->source}}</td></tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class = "col-4">
                        <div class = "card border-light">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <div>Договоры</div>
                                    <div><i class="fa-sharp fa-solid fa-file-word"></i></div>
                                </h5>
                                @if(count($all['alldogovors']) == 0)
                                    <h1 class="card-text">0
                                    </h1>
                                @endif
                                <table class="table table-sm">
                                    <tbody>
                                    @foreach($all['alldogovors'] as $el)
                                        <tr class="my-3"><td><a href="{{$el->url}}" class="text-decoration-none" target="_blank">{{$el->name}}<i class="bi bi-cloud-download mx-3"> </i></a></td><td>{{$el->allstoimost}}</td></tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class = "col-4">
                        <div class = "card border-light">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <div>Платежи</div>
                                    <div><i class="fa-sharp fa-solid fa-file-invoice-dollar"></i></div>
                                </h5>
                                @if(count($all['allpayments']) == 0)
                                    <h1 class="card-text">0
                                    </h1>
                                @endif
                                <table class="table table-sm">
                                    <tbody>
                                    @foreach($all['allpayments'] as $el)
                                        <tr class="my-3"><td><a href="payments/{{$el->id}}" class="text-decoration-none" target="_blank">{{$el->client}}</a></td><td>{{$el->summ}}</td></tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "row mt-2">
                <div class = "col-4">
                    <div class = "card border-light">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between">
                                <div>Лиды</div>
                                <div><i class="fa-sharp fa-solid fa-person-circle-plus"></i></div>
                            </h5>
                            @if(count($all['allleads']) == 0)
                                <h1 class="card-text">0
                                </h1>
                            @endif
                            <table class="table table-sm">
                                <tbody>
                                @foreach($all['allleads'] as $el)
                                    <tr class="my-3"><td><a href="leads/{{$el->id}}" class="text-decoration-none" target="_blank">{{$el->name}}</a></td><td>{{$el->phone}}</td></tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class = "col-4">
                    <div class = "card border-light">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between">
                                <div>Лиды просрочены</div>
                                <div><i class="fa-sharp fa-solid fa-person-walking-luggage"></i></div>
                            </h5>
                            @if(count($all['allleadsoverdue']) == 0)
                                <h1 class="card-text">0
                                </h1>
                            @endif
                            <table class="table table-sm">
                                <tbody>
                                @foreach($all['allleadsoverdue'] as $el)
                                    <tr class="my-3"><td><a href="leads/{{$el->id}}" class="text-decoration-none" target="_blank">{{$el->name}}</a></td><td>{{$el->phone}}</td></tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class="card m-3 pb-5 w-75">
                    <div class="card-body">
                        <div class = "d-flex justify-content-between align-items-center mb-3">
                           <span class="fs-4">Доходы</span>
                            <span>
                                <a class="btn btn-light" href="/payments">
                                    <i class="bi-three-dots"></i>
                                </a>
                            </span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="col-3 text-left"><i class="bi bi-wallet2 " style="font-size: 3rem; color: indigo;"></i></div>
                            <div class="col-9 d-flex justify-content-center text-center">
                                <div class="col d-flex flex-column justify-content-center">
                                    <h6 class="card-subtitle mb-2 text-muted">привлек + превышение</h6>
                                    <div class="fs-2 mx-3">{{$data['paymentsattr']}} + {{$data['paymentsmodifyattr']}}</div>
                                </div>
                                <div class="col d-flex flex-column justify-content-center">
                                    <h6 class="card-subtitle mb-2 text-muted">продал  + превышение</h6>
                                    <div class="fs-2 mx-3">{{$data['paymentsseller']}} + {{$data['paymentsmodifyseller']}}</div>
                                </div>
                                <div class="col d-flex flex-column justify-content-center">
                                    <h6 class="card-subtitle mb-2 text-muted">развил направление</h6>
                                    <div class="fs-2 mx-3">{{$data['paymentsdev']}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
