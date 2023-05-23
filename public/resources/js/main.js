$(document).ready(function() {
    // При клике на кнопку 'Добавить дело'
    // берем значения аттрибутов (имя клиента, id клиента) и подставляем по умолчанию в input text, input hidden
    $(".addDeal").on('click', function() {
        var clientId = $(this).attr('data-client-id');
        document.getElementById("clientId").value = clientId;
    });

    // При клике на кнопку 'Добавить задачу' из раздела 'Клиенты'
    // берем значения аттрибутов (имя клиента, id клиента) и подставляем по умолчанию в input text, input hidden
    $(".nameToForm").click(function(el) {
        // Заполнение формы при создании задачи
        if (!$(this).hasClass('edit')) {
            fillForm($(this));
        }

        if ($(this).hasClass('lead')) {
            var leadIdValue = $(this).attr('data-lead-id');
            document.getElementById('lead_id').value = leadIdValue;
        }

        if ($(this).hasClass('clientTask')) {
            var namevalue = $(this).attr('data-client');
            var clientIdValue = $(this).attr('data-value-id');
            document.getElementById("client").value = namevalue;
            document.getElementById("clientidinput").value = clientIdValue;

            var taskIdValue = null;
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
        }
    });

    // Заполнение полей формы в модальном окне "Добавить задачу" в разделе Клиенты
    function fillForm(element) {
        var type = element.attr('data-type');
        document.getElementById("taskname").innerHTML = type;
        document.getElementById("nameoftask").value = '';
        document.getElementById("duration").value = 1;
        document.getElementById("type").value = type;
        var collection = document.getElementsByClassName("hideme")
        for (let i = 0; i < collection.length; i++) {
            collection[i].style.display = "block";
        }
        document.getElementById("lawyer").value = element.attr('data-user-id');
        document.getElementById("soispolintel").value = element.attr('data-user-id');
        var now = new Date();
        now.setHours(23);
        now.setMinutes(00);
        document.getElementById("date").value = now.toISOString().slice(0,16);
    }

    $('[data-toggle="tooltip"]').tooltip();

    // Фильтр по дате/выбору пользователя на Главной странице в админке
    $('.input-home-filter').on('change', function () {
        $('#form-filter').submit();
    });

    // Копирование ссылки на Главной странице в админке
    $('#btnurl').on('click', function () {
        // Get the text field
        var copyText = document.getElementById("calendarurl");
        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);
        // Alert the copied text
        document.getElementById("btnurl").innerText = 'ссылка скопирована';
    });

    // Datetimepicker
    if (typeof $('input#date').datetimepicker !== "undefined") { //check if function exist to avoid err
        $('input#date').datetimepicker({
            lang: 'ru',
            step: 15, //more useful for lawyers
            minTime:'8:00',
            maxTime:'22:00'
        });
    }

    // Подгрузка списка клиентов при клике на поле "Клиент" у формы Задач
    $('#client').keyup(function() {
        var query = $(this).val();
        var quantity = $(this).val().length;

        if(quantity > 2)
        {
            $.ajax({
                url: "/getclient",
                method: "POST",
                data: {query:query},
                success: function (data) {
                    $('#clientList').fadeIn();
                    $('#clientList').html(data);
                }
            });
        }
    });

    // Выбор клиента из выпадающего списка в форме Задачи
    $(document).on('click', '.clientAJAX', function() {
        $('#clientidinput').val($(this).val());
        $('#client').val($(this).text());
        $('#clientList').fadeOut();
    });
});
