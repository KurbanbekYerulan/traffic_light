<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Светофор</title>
    <!-- CSRF токен для обеспечения безопасности AJAX запросов -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Основные стили для светофора и его цветов */
        #traffic-light .light {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin: 5px auto;
            opacity: 0.3; /* Светофор в выключенном состоянии */
        }

        #green { background-color: green; }
        #yellow { background-color: yellow; }
        #red { background-color: red; }

        .active {
            opacity: 1 !important; /* Стиль для активного состояния светофора */
        }

        /* Стили для таблицы логов */
        table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        th { background-color: #f2f2f2; } /* Шапка таблицы */
    </style>
    <!-- Подключение jQuery для работы скриптов -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Подключение основных стилей и скриптов приложения -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
    <!-- Контейнер для светофора и кнопки "Вперед" -->
    <div id="traffic-light">
        <!-- Индивидуальные цвета светофора -->
        <div class="light" id="green"></div>
        <div class="light" id="yellow"></div>
        <div class="light" id="red"></div>
    </div>
    <!-- Кнопка для инициации действия -->
    <div>
        <button id="goButton" style="margin-left: 20px;">Вперед</button>
    </div>
</div>

<!-- Таблица для отображения логов -->
<table>
    <thead>
    <tr>
        <th>Сообщение</th>
    </tr>
    </thead>
    <tbody id="logTable">
    <!-- Вывод записей логов из базы данных -->
    @foreach($logs as $log)
        <tr>
            <td>{{ $log->message }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
