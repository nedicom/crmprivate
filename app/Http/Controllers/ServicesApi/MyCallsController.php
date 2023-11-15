<?php

namespace App\Http\Controllers\ServicesApi;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Client\Request;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

/**
 * Интеграция сервиса Мои звонки
 * @see https://www.moizvonki.ru/guide/api
 */
class MyCallsController extends Controller
{
    /**
     * Подписка на события через Webhook
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribeCall()
    {
        $jsonReqBody = json_encode([
            'user_name' => config('services.my_calls.username'),
            'api_key' => config('services.my_calls.api_key'),
            'action' => 'webhook.subscribe',
            'hooks' => [
                //'call.start' => 'https://38e1-46-45-197-26.ngrok-free.app/mycalls/action/call-start',
                'call.finish' => 'https://38e1-46-45-197-26.ngrok-free.app/mycalls/action/call-finished',
            ],
        ]);
        /** @var \Illuminate\Http\Client\Response $response */
        $response = Http::myCalls()->asForm()->post('', [
            'request_data' => $jsonReqBody,
        ]);

        if ($response->ok()) {
            return back()->with('success', 'Выполнена подписка на события сервиса Мои звонки.');
        } else {
            Log::notice('Не удалось подписаться на события сервиса Мои звноки');
            return back()->with('error', 'Не удалось подписаться на события сервиса Мои звонки.');
        }
    }

    /**
     * Отписка от событий через Webhook
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribeCall()
    {
        $jsonReqBody = json_encode([
            'user_name' => config('services.my_calls.username'),
            'api_key' => config('services.my_calls.api_key'),
            'action' => 'webhook.unsubscribe',
            'hooks' => [
                'call.start',
                'call.finish',
            ],
        ]);
        /** @var \Illuminate\Http\Client\Response $response */
        $response = Http::myCalls()->asForm()->post('', [
            'request_data' => $jsonReqBody,
        ]);

        if ($response->ok()) {
            return back()->with('success', 'Выполнена отписка от событий сервиса Мои звонки.');
        } else {
            Log::notice('Не удалось отписаться от событий сервиса Мои звноки.');
            return back()->with('error', 'Не удалось отписаться от событий сервиса Мои звноки.');
        }
    }

    public function actionCallStart(Request $request)
    {
        Log::notice(json_encode($request->all(), JSON_UNESCAPED_UNICODE));
    }

    public function actionCallFinished(Request $request)
    {
        Log::notice(json_encode($request->all(), JSON_UNESCAPED_UNICODE));
    }
}
