$(document).ready(function() {
    // При клике на кнопку 'Добавить дело'
    // берем значения аттрибутов (имя клиента, id клиента) и подставляем по умолчанию в input text, input hidden
    $(".addDeal").on('click', function() {
        var clientId = $(this).attr('data-client-id');
        document.getElementById("clientId").value = clientId;
    });

    // При клике на кнопку 'Добавить задачу'
    // берем значения аттрибутов (имя клиента, id клиента) и подставляем по умолчанию в input text, input hidden
    $(".nameToForm").click(function() {
        var namevalue = $(this).attr('data-client');
        var clientIdValue = $(this).attr('data-value-id');
        var taskIdValue = null;
        document.getElementById("client").value = namevalue;
        document.getElementById("clientidinput").value = clientIdValue;
        if (typeof $(this).attr('data-task-id') !== typeof undefined && $(this).attr('data-task-id') !== false) {
            taskIdValue = $(this).attr('data-task-id');
        }

        // Подгружаем список дел клиента
        $.ajax({
            url: "/tasks/get-deals",
            method: "POST",
            data: {clientId: clientIdValue, taskId: taskIdValue},
            success: function (data) {
                $('.list-deals-block').html(data);
            }
        });
    });
});
