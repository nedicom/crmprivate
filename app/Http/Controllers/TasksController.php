<?php

namespace App\Http\Controllers;

use App\Events\Task\TaskCompleted;
use App\Events\Task\TaskCreated;
use Illuminate\Http\Request;
use App\Http\Requests\TasksRequest;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

  class TasksController extends Controller{

    public function index(Request $request) {
      $lawyerfilter = $typefilter = null;
      $checkedlawyer = $type = null;
      $calendar = $request->input('calendar');//month, year, day
      if($request->input('checkedlawyer')){$lawyerfilter='lawyer'; $checkedlawyer = $request->input('checkedlawyer');}//lawyer
      if($request->input('type')){$typefilter='type'; $type = $request->input('type');}//type

        //if(!empty($checkedlawyer)){ //checkedlawyer no empty
        if($calendar == 'week') {
              return view ('tasks/tasks', ['data' => Tasks::select("*")
              ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
              ->where($lawyerfilter, '=', $checkedlawyer)
              ->where($typefilter, '=', $type)
              ->orderBy('date', 'asc')
              ->get()],
              ['datalawyers' =>  User::all()]);
        }

            elseif ($calendar == 'day') {
              return view ('tasks/tasks', ['data' => Tasks::select("*")
              ->whereBetween('date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
              ->where($lawyerfilter, '=', $checkedlawyer)
              ->where($typefilter, '=', $type)
              ->orderBy('date', 'asc')
              ->get()],
              ['datalawyers' =>  User::all()]);
            }

            elseif($calendar == 'month'){
              if($addmonts = $request->input('months')){
                $addmonts = ($request->input('months'));
              }
              else{$addmonts = ((Carbon::now()->month)-1);
              }
              //dd((Carbon::now()->month)-1);
              //$localmonth = $gettmonth->locale('ru_RU')->monthName;
              return view ('tasks/tasks', ['data' => Tasks::select("*")
              ->whereBetween('date', [Carbon::now()->startOfYear()->addMonth($addmonts), Carbon::now()->startOfYear()->addMonth($addmonts+1)])
              ->where($lawyerfilter, '=', $checkedlawyer)
              ->where($typefilter, '=', $type)
              ->orderBy('date', 'asc')
              ->get()],
              ['datalawyers' =>  User::all()]);
            }

            else{
              return view ('tasks/tasks', ['data' => Tasks::select("*")
              ->where($lawyerfilter, '=', $checkedlawyer)
              ->where($typefilter, '=', $type)
              ->orderBy('date', 'asc')
              ->get()],
              ['datalawyers' =>  User::all()]);
            }

         // }
    }

        public function create(TasksRequest $req){
            $task = new Tasks();

            $task -> name = $req -> nameoftask;
            $task -> client = $req -> client;
            $task -> date = $req -> date;
            $task -> lawyer = $req -> lawyer;
            $task -> duration = $req -> duration;
            $task -> clientid = $req -> clientidinput;
            $task -> new = 1;
            if($req -> hrftodcm){$task -> hrftodcm = $req -> hrftodcm;};
            if($req -> type){$task -> type = $req -> type;};

            $task -> postanovshik = Auth::user()->id;
            if($req -> tag){$task -> tag = $req -> tag;};
            if($req -> soispolintel){$task -> soispolintel = $req -> soispolintel;};
            if($req -> description){$task -> description = $req -> description;};
            $task -> status = 'ожидает';

            $task -> save();

            TaskCreated::dispatch($task);

            return redirect()->back()-> with('success', 'Все в порядке, событие добавлено');
        }

        public function tag(Request $request){
          if($request->get('id')){
            $id = $request->get('id');
            $task = Tasks::find($id);
            $task -> tag = $request->get('value');
            $task -> save();
          }
        }


        public function showTaskById($request){
           $task = Tasks::find($request);
           if($task -> lawyer == Auth::user()->id){
            $task -> new = 0;
            $task -> save();
          }
          return view ('tasks/taskById', ['data' => Tasks::find($request)], ['datalawyers' =>  User::all()]);
        }

        public function editTaskById($id, TasksRequest $req){
          $task = Tasks::find($id);

          $task -> name = $req -> nameoftask;
          $task -> client = $req -> client;
          $task -> date = $req -> date;
          $task -> lawyer = $req -> lawyer;
          $task -> duration = $req -> duration;
          $task -> status = $req -> status;

          if($req -> tag){$task -> tag = $req -> tag;};
          if($req -> postanovshik){$task -> postanovshik = $req -> postanovshik;};
          if($req -> soispolintel){$task -> soispolintel = $req -> soispolintel;};
          if($req -> description){$task -> description = $req -> description;};

          if($req -> hrftodcm){$task -> hrftodcm = $req -> hrftodcm;};
          if($req -> type){$task -> type = $req -> type;};
          if($req -> clientidinput){$task -> clientid = $req -> clientidinput;};

          $task -> save();

          if ($task->status === 'выполнена') {
              TaskCompleted::dispatch($task);
          }

          return redirect() -> route('showTaskById', $id) -> with('success', 'Все в порядке, событие обновлено');
        }

        public function TaskDelete($id){
            Tasks::find($id)->delete();
            return redirect() -> route('tasks') -> with('success', 'Все в порядке, задача удалена');
        }
    }
