<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail as Mailer;

class MailController extends Controller
{
    public function __invoke(Request $request)
    {
        $to = $request->input('to', 'pokerdn2010@gmail.com');
        $subject = $request->input('s', 'Lead from site');
        $body = $request->input('b');

        Mailer::raw($body, static function (Message $message) use ($to, $subject) {
            $message->subject($subject)
                ->to($to);
        });

        return 1;
    }
}
