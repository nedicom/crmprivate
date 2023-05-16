<div class="row">
    <div class="col-6 mb-3 form-group">
        <label for="list-deals">Выберите дело</label>
        <select class="form-select" name="deals" id="list-deals">
            <option value='{{ null }}'>Дело не выбрано</option>
            @foreach ($deals->where('status', 1)->get() as $deal)
                <option value='{{$deal->id}}' @if ($task) @if ($deal->id == $task->deal_id) selected @endif @endif>{{ $deal->name }}</option>
            @endforeach
        </select>
    </div>
</div>
