<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrafficLightController extends Controller
{
    /**
     * Отображает главную страницу светофора.
     * Загружает последние 10 записей логов из базы данных и передает их в представление.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $logs = Log::latest()->take(10)->get();
        return view('traffic_light', compact('logs'));
    }

    /**
     * Обрабатывает запрос на сохранение новой записи в лог.
     * Валидирует входящий запрос, и в случае успеха, сохраняет запись в базу данных.
     * Возвращает JSON ответ с результатом операции.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:255',
        ]);

        // Если валидация не прошла, возвращаем ошибки
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Создаем новую запись в базе данных с полученным сообщением
        $log = Log::create(['message' => $request->message]);

        // Возвращаем успешный JSON ответ
        return response()->json(['success' => true, 'message' => $log->message]);
    }
}
