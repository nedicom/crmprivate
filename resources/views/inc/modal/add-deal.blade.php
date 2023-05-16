<div class="modal fade" id="dealModal">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class ="modal-header">
                <h2>+ <span id="dealname">Дело</span></h2>
            </div>
            <div class ="modal-body d-flex justify-content-center">
                <div class ="col-10">
                    <form action="{{route('deal.store')}}" autocomplete="off" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Укажите название дела <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Описание</label>
                            <textarea rows="3" name="description" id="description" placeholder="Немного подробнее, если это нужно" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-3 form-group mb-3">
                                <label for="status">Cтатус</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="{{ \App\Models\Deal::STATUS_ACTIVE }}">Активно</option>
                                    <option value="{{ \App\Models\Deal::STATUS_INACTIVE }}">Не активно</option>
                                </select>
                            </div>
                            <div class="col-4 form-group mb-3">
                                <label for="lawyerId">Укажите юриста <span class="text-danger">*</span></label>
                                <select class="form-select" name="lawyerId" id="lawyerId">
                                    @foreach ($datalawyers as $user)
                                        <option value="{{ $user->id }}" @if ((Auth::user()->id) == $user->id) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input name="clientId" id="clientId" type="hidden" class="form-control" value="">
                        <button type="submit" id='submit' class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
