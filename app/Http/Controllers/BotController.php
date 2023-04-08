<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;

class BotController extends Controller
{
    public function index() {
        /**
         * Setting webhok
         * https://api.telegram.org/bot5941198915:AAFpQD_AvVJfiXjH6gaD3oBZgxbe06sTvyc/setWebhook?url=https://crm.nedicom.ru/bot
         */

        $token = config('app.bot_client.token');
        $inputdata = file_get_contents('php://input');
        $pass = 123;
        $data = json_decode($inputdata, true);
        $chatid	= $data['message']['chat']['id'];
        $message = $data['message']['text'];
        $urlfile = 'pass/'.$chatid.'.txt';

        $jsonobj = Storage::get($urlfile);
        $obj = json_decode($jsonobj);
        $checkpass = 0;
        $clientchoise = 0;
            if (json_last_error() === 0) {
                $checkpass = $obj->pass;
                $clientchoise = $obj->clientchoise;
            }




        $keyboard['keyboard'][0] = ['в начало'];
        $tasklist = ['просроченные', 'новые', 'на сегодня'];
        $taskkeyboard = ['keyboard'=>[
                                                [['text'=>'в начало', 'callback_data' => 'plz']],
                                                [['text'=>'просроченные', 'callback_data' => 'pld']],
                                                [['text'=>'новые', 'callback_data' => 'new']],
                                                [['text'=>'на сегодня', 'callback_data' => 'today']]
                                            ],
                        'one_time_keyboard' => true];
        $k = 1;
        $userlist = [];
            foreach (User::all() as $lawyer) {
                $userlist[$lawyer->id] = $lawyer->name;
                $keyboard['keyboard'][$k] = [$lawyer->name];
                $k++;
            }

        $getQuery = array(
            "chat_id" 	=> $data['message']['chat']['id'],
            "parse_mode" => "html",
        );


        if(!empty($message)) {
                if($message == '/start' || $message == 'в начало'){
                    $getQuery['text'] =  'Введите пароль';
                    $userchoise = ['pass' => 0, 'userchoise' => 0, 'clientchoise' => 0];
                    $json = json_encode($userchoise);
                    Storage::put($urlfile, print_r($json, true));
                }
                elseif($message == '/client'){
                    $getQuery['text'] =  'Введите уникальный пароль клиента';
                    $userchoise = ['pass' => 0, 'userchoise' => 0, 'clientchoise' => '/client'];
                    $json = json_encode($userchoise);
                    Storage::put($urlfile, print_r($json, true));
                }
                elseif($message == $pass){
                    $getQuery['text'] =  'Вы ввели пароль правильно. Давайте выберем юриста.';
                    $getQuery['reply_markup'] = json_encode($keyboard);
                    $userchoise = ['pass' => $pass, 'userchoise' => 0, 'clientchoise' => 0];
                    $json = json_encode($userchoise);
                    Storage::put($urlfile, print_r($json, true));
                }
                elseif($clientchoise == '/client'){
                    $client = DB::table('clients_models')->where('tgid', $message)-> value('id');

                        if(!empty($client)){
                            $tasks = Tasks::where('clientid', $client)->where('status', '!=', 'выполнена')-> get();
                            $name = DB::table('clients_models')->where('tgid', $message)->value('name');
                            $textMessage = '<b>'.$name.'</b>'."\n";
                            if(count($tasks)){
                                foreach($tasks as $el){
                                    $textMessage .= '<b>'.$el -> name.'</b>'."\n";
                                    $textMessage .= $el['date']['currentDay'].' '.$el['date']['currentMonth'].', '.$el['date']['currentTime']."\n";
                                    $textMessage .=  $el -> status."\n";
                                    $textMessage .= '<i>'.$el -> description.'</i>'."\n"."\n";
                                }
                            }
                            else{
                                $getQuery['text'] = 'У клиента нет задач';
                            }
                            $getQuery['text'] =  $textMessage;
                            $userchoise = ['pass' => 0, 'userchoise' => 0, 'clientchoise' => 0];
                            $json = json_encode($userchoise);
                            Storage::disk('local')->put($urlfile, print_r($json, true));
                        }
                        else{
                            $getQuery['text'] =  'Пароль клиента неправильный. Начните заново';
                            $userchoise = ['pass' => 0, 'userchoise' => 0, 'clientchoise' => 0];
                            $json = json_encode($userchoise);
                            Storage::disk('local')->put($urlfile, print_r($json, true));
                        }
                }
                elseif($checkpass == $pass){
                    if(in_array($message, $userlist)){
                        $getQuery['text'] = 'Вы выбрали  - '.$message;
                        $getQuery['reply_markup'] = json_encode($taskkeyboard);
                        $key = array_search($message, $userlist);
                        $userchoise = ['pass' => $checkpass, 'userchoise' => $key, 'clientchoise' => 0];
                        $json = json_encode($userchoise);
                        Storage::disk('local')->put($urlfile, print_r($json, true));
                    }

                    elseif(in_array($message, $tasklist)){
                        $userchoise = $obj->userchoise;
                        if($message == 'новые'){
                            $tasks = Tasks::where('new', 1)->where('lawyer', $userchoise)-> get();
                        }
                        elseif($message == 'просроченные'){
                            $oldtasks = Tasks::where('lawyer', $userchoise)-> get();
                                foreach($oldtasks as $oldel){
                                    if(Carbon::now()->gte([$oldel -> date][0]['value']) && $oldel -> status != 'выполнена'){
                                        $oldel -> status = 'просрочена';
                                        $oldel -> save();
                                      }
                                }
                            $tasks = Tasks::where('status', 'просрочена')->where('lawyer', $userchoise)-> get();
                        }
                        elseif($message == 'на сегодня'){
                            $tasks = Tasks::whereBetween('date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->where('lawyer', $userchoise)-> get();
                        }
                        else{
                            $getQuery['text'] =  'пропробуйте еще раз';
                        }

                        $textMessage = "";

                        if(count($tasks)){
                            foreach($tasks as $el){
                                $textMessage .= '<b>'.$el -> name.'</b>'."\n";
                                $textMessage .= $el['date']['currentDay'].' '.$el['date']['currentMonth'].', '.$el['date']['currentTime']."\n";
                                $textMessage .=  $el -> client."\n";
                                $textMessage .= '<i>'.$el -> description.'</i>'."\n"."\n";
                            }
                        }
                        else{
                            $textMessage = 'нет задач';
                            $getQuery['reply_markup'] = json_encode($taskkeyboard);
                        }
                        $getQuery['text'] =  $textMessage;
                    }
                    else{
                        $getQuery['text'] =  'Введите пароль или начните заново (кнопка menu)';
                        $userchoise = ['pass' => 0, 'userchoise' => 0, 'clientchoise' => 0];
                        $json = json_encode($userchoise);
                        Storage::disk('local')->put($urlfile, print_r($json, true));
                    }
                }
                else{
                    $getQuery['text'] =  'Пароль неправильный. Начните заново';
                    $userchoise = ['pass' => 0, 'userchoise' => 0, 'clientchoise' => 0];
                    $json = json_encode($userchoise);
                    Storage::put($urlfile, print_r($json, true));
                }

        }

        $ch = curl_init("https://api.telegram.org/bot". $token ."/sendMessage?" . http_build_query($getQuery));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $resultQuery = curl_exec($ch);
        curl_close($ch);
    }
}
