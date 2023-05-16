<div class="modal fade" id="editDealModal">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class ="modal-header">
                <h2>Изменить дело</h2>
            </div>
            <div class ="modal-body d-flex justify-content-center">
                <div class ="col-10">
                    <form action="{{ route('deal.update', ['id' => $deal->id]) }}" autocomplete="off" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Укажите название дела <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" value="{{ $deal->name }}" placeholder="" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Описание</label>
                            <textarea rows="3" name="description" id="description" placeholder="Немного подробнее, если это нужно" class="form-control">{{ $deal->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-3 form-group mb-3">
                                <label for="status">Cтатус</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="{{ \App\Models\Deal::STATUS_ACTIVE }}" @if ($deal->status == \App\Models\Deal::STATUS_ACTIVE) selected @endif>Активно</option>
                                    <option value="{{ \App\Models\Deal::STATUS_INACTIVE }}" @if ($deal->status == \App\Models\Deal::STATUS_INACTIVE) selected @endif>Не активно</option>
                                </select>
                            </div>
                            <div class="col-4 form-group mb-3">
                                <label for="lawyerId">Укажите юриста <span class="text-danger">*</span></label>
                                <select class="form-select" name="lawyerId" id="lawyerId">
                                    @foreach ($datalawyers as $user)
                                        <option value="{{ $user->id }}" @if ($deal->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input name="clientId" id="clientId" type="hidden" class="form-control" value="{{ $deal->client_id }}">
                        <button type="submit" id='submit' class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
