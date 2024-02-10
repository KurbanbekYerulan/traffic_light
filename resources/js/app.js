$(document).ready(function() {
    // Инициализируем индекс текущего цвета
    let currentColorIndex = 0;

    // Определяем массив цветов светофора и соответствующие сообщения
    const colors = [
        { id: 'green', duration: 5000, message: "Проезд на зеленый!" },
        { id: 'yellow', duration: 2000, message: "Успели на желтый!" },
        { id: 'red', duration: 5000, message: "Проезд на красный. Штраф!" },
        { id: 'yellow', duration: 2000, message: "Слишком рано начали движение!" }
    ];

    /**
     * Изменяет активный цвет светофора и переключает его после задержки.
     * Удаляет класс 'active' у всех цветов, затем добавляет его текущему цвету.
     * Планирует следующую смену цвета через заданное время.
     */
    function changeColor() {
        $('#traffic-light .light').removeClass('active');
        const currentColor = colors[currentColorIndex];
        $('#' + currentColor.id).addClass('active');

        setTimeout(() => {
            currentColorIndex = (currentColorIndex + 1) % colors.length;
            changeColor();
        }, currentColor.duration);
    }

    // Начинаем цикл смены цветов
    changeColor();

    /**
     * Обрабатывает нажатие на кнопку "Вперед".
     * Отправляет AJAX запрос на сервер с сообщением текущего цвета.
     * В случае успеха добавляет запись в таблицу логов.
     * Обрабатывает возможные ошибки запроса.
     */
    $('#goButton').click(function() {
        const currentColor = colors[currentColorIndex];
        const message = currentColor.message;

        $.ajax({
            url: '/log',
            type: 'POST',
            data: {
                message: message,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#logTable').prepend(`<tr><td>${response.message}</td></tr>`);
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    console.error("Ошибки проверки:", errors);
                } else {
                    console.error("Произошла ошибка");
                }
            }
        });
    });
});
