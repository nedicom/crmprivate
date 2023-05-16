<?php

namespace App\Console\Commands\Test;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail as Mailer;

class Mail extends Command
{
    protected $signature = 'test:mail {email=pokerdn2010@gmail.com}';

    protected $description = 'Тестирование отправки почты через провайдера по умолчанию';

    public function handle(): int
    {
        $email = $this->argument('email');

        $default = config('mail.default');

        dump($default);
        dump(config('mail.mailers.' . $default));
        dump(config('mail.from'));

        Mailer::raw('It`s ok!', static function (Message $message) use ($email) {
            $message->subject('Demo mail from server')
                ->to($email);
        });

        $this->warn('Email was sent');

        return 0;
    }
}
