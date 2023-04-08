<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Tasks;

class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule)
    {

        $schedule->command('telescope:prune')->hourly();

        $schedule->call(function () {

            DB::table('tasks')->where('date', '<', Carbon::now())
                ->where('status', '!=', 'выполнена')
                ->update(['status' => 'просрочена']);

            $users = USER::all();
            $myfile = fopen('test.txt', "w") or die("Unable to open file!");
            foreach ($users as $user){

                        //$to = "m6132@yandex.ru";
                        //$topic = "Ваши задачи";
                        //$msg = $user -> name;
                        //$msg = wordwrap($msg,100);
                        //$headers = "From: crm@nedicom.ru";
                        //mail($to, $topic,$msg,$headers);

                        $id = $user -> id;
                        fwrite($myfile, $user -> name);
                        fwrite($myfile, 'исполнитель');

                        $tasks = Tasks::where('lawyer', $id)->get();
                            foreach ($tasks as $task){
                                fwrite($myfile, $task->name);
                            }
                            fwrite($myfile, 'соисполнитель');
                            $tasks = Tasks::where('soispolintel', $id)->get();
                                foreach ($tasks as $task){
                                    fwrite($myfile, $task->name);
                                }
                                $tasks = Tasks::where('postanovshik', $id)->get();
                                foreach ($tasks as $task){
                                    fwrite($myfile, $task->name);
                                }


            }
            fclose($myfile);
        })->everyMinute();

    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
