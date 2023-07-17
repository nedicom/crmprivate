<!-- Список услуг для формы Задач -->
<span class="close" style="color:red; float:right; cursor:pointer">Скрыть список</span>
<div class="holder-filter-service mb-3">
    <div class="form-group">
        <label class="mb-2" style="display: block;" for="filter-name-service">
            <strong>Поиск услуги по ее названию:</strong>
        </label>
        <input id="filter-name-service" name="filter-name-service" class="form-control" type="text" placeholder="Введите значение поиска">
    </div>
</div>
<div class="holder-services-list">
    <h6>Список услуг</h6>
    <ul class="list-group">
        @include('inc/modal/_list-services', compact('services'))
    </ul>
</div>
