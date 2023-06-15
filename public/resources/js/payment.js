$(document).ready(function() {
    // Подгрузка списка задач при клике на поле "Выбор задачи" у формы Платежей
    $(document).on('keyup', '.task-input', function() {
        var query = $(this).val();
        var elem = $(this);

        if($(this).val().length > 2) {
            $.ajax({
                url: "/tasks/list/ajax",
                method: "POST",
                data: {query: query},
                success: function (data) {
                    var list = elem.parents($('.tasksIndex')).children('.tasksList');
                    list.fadeIn();
                    list.html(data);
                }
            });
        }
    });
    // Динамические поля платежей
    $("#add-task").on('click', function() {
        $("#tasksTable").append('<tr><td width="200">' +
            '<div class="task-input-block">' +
            '<input type="text" name="taskClient[]" placeholder="Введите имя клиента" class="task-input form-control" />' +
            '<input type="hidden" name="taskID[]" class="task-id" value="" />' +
            '<div class="tasksList" style="display:none"></div>' +
            '</div></td>' +
            '<td class="info-task"></td>' +
            '<td><button type="button" class="btn btn-danger remove-tr">Удалить</button>' +
            '</td></tr>'
        );
    });
    // Удаление в таблице строки задачи
    $(document).on('click', '.remove-tr', function() {
        $(this).parents('tr').remove();
    });
    // Выбор задачи из выпадающего списка в форме Платежа
    $(document).on('click', '.taskIndex', function() {
        var parent = $(this).parents($('.task-input-block'));
        parent.children('.task-id').val($(this).attr('data-task-id'));
        parent.children('input.task-input').val($(this).find($('.name-client')).text());
        $(this).parents($('#tasksTable')).children('tr:last').children('td.info-task').text($(this).text());
        $('.tasksList').fadeOut();
    });
});
