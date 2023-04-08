<?php

namespace App\Http\Controllers\Bots;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;
class StaffController extends Controller
{
    public Nutgram $bot;

    /**
     * @param Nutgram $bot
     */
    public function __construct(Nutgram $bot)
    {
        $this->bot = $bot;
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Request $request)
    {
        Log::debug('StaffController', $request->all());

        $this->bot->setRunningMode(Webhook::class);

        $this->bot->onCommand('start', function (Nutgram $bot) {
            $bot->sendMessage("Для использования бота подключите его с главной страницы CRM перейдя по указанной там ссылке.");
        });

        $this->bot->onCommand('start {parameter}', function (Nutgram $bot, string $parameter) {
            $userId = base64_decode($parameter);

            $user = User::find($userId);

            if (empty($user)) {
                $bot->sendMessage("Не найден пользователь.");
                return;
            }

            $user->update([
                'tg_id' => $bot->user()->id,
            ]);

            $bot->sendMessage("Бот-информер подключен к аккаунту пользователя {$user->name}.");
        });

        $this->bot->onCommand('help', function (Nutgram $bot) {
            $bot->sendMessage('Для использования бота подключите его с главной страницы CRM перейдя по указанной там ссылке. Дальше Вы начнете получать извещения в телеграм.');
        });

        $this->bot->onCommand('about', function (Nutgram $bot) {
            $bot->sendMessage('Бот предназначен для извещений о новых и выполненных задачах.');
        });

        $this->bot->fallback(function (Nutgram $bot) {
            $bot->sendMessage('Неизвестная команда.');
        });

        $this->bot->registerMyCommands();

        $this->bot->run();
    }
}
