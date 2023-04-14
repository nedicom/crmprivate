<?php

namespace App\Http\Controllers;

use App\Events\Task\TaskCompleted;
use App\Events\Task\TaskCreated;
use App\Models\ClientsModel;
use Illuminate\Http\Request;
use App\Http\Requests\TasksRequest;
use App\Models\Tasks;
use App\Models\User;
use App\Models\Deal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        $lawyerfilter = $typefilter = null;
        $checkedlawyer = $type = null;
        $calendar = $request->input('calendar'); //month, year, day
        if($request->input('checkedlawyer')){$lawyerfilter='lawyer'; $checkedlawyer = $request->input('checkedlawyer');} //lawyer
        if($request->input('type')){$typefilter='type'; $type = $request->input('type');} //type

        if ($calendar == 'week') {
            return view ('tasks/tasks', ['data' => Tasks::select("*")
                ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->where($lawyerfilter, '=', $checkedlawyer)
                ->where($typefilter, '=', $type)
                ->orderBy('date', 'asc')
                ->get()],
                ['datalawyers' =>  User::all()]
            );
        } elseif ($calendar == 'day') {
            return view ('tasks/tasks', ['data' => Tasks::select("*")
                ->whereBetween('date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
                ->where($lawyerfilter, '=', $checkedlawyer)
                ->where($typefilter, '=', $type)
                ->orderBy('date', 'asc')
                ->get()],
                ['datalawyers' =>  User::all()]
            );
        } elseif ($calendar == 'month') {
              if ($addmonts = $request->input('months')) {
                  $addmonts = ($request->input('months'));
              } else {
                  $addmonts = ((Carbon::now()->month)-1);
              }

              return view ('tasks/tasks', ['data' => Tasks::select("*")
                  ->whereBetween('date', [Carbon::now()->startOfYear()->addMonth($addmonts), Carbon::now()->startOfYear()->addMonth($addmonts+1)])
                  ->where($lawyerfilter, '=', $checkedlawyer)
                  ->where($typefilter, '=', $type)
                  ->orderBy('date', 'asc')
                  ->get()],
                  ['datalawyers' =>  User::all()]
              );
        } else {
            return view ('tasks/tasks', ['data' => Tasks::select("*")
                ->where($lawyerfilter, '=', $checkedlawyer)
                ->where($typefilter, '=', $type)
                ->orderBy('date', 'asc')
                ->get()],
                ['datalawyers' =>  User::all()]
            );
        }
    }

    public function create(TasksRequest $req)
    {
        $task = new Tasks();
        $task->name = $req->nameoftask;
        $task->client = $req->client;
        $task->date = $req->date;
        $task->lawyer = $req->lawyer;
        $task->duration = $req->duration;
        $task->clientid = $req->clientidinput;
        $task->deal_id = ($req->deals !== null) ? $req->deals : null;
        $task->new = 1;
        if($req -> hrftodcm){$task->hrftodcm = $req->hrftodcm;};
        if($req -> type){$task->type = $req->type;};

        $task->postanovshik = Auth::user()->id;
        if($req->tag){$task->tag = $req->tag;};
        if($req->soispolintel){$task->soispolintel = $req->soispolintel;};
        if($req->description){$task->description = $req->description;};
        $task->status = 'ожидает';

        $task->save();

        TaskCreated::dispatch($task);

        return redirect()->back()->with('success', 'Все в порядке, событие добавлено');
    }

    public function tag(Request $request)
    {
        if ($request->get('id')) {
            $id = $request->get('id');
            $task = Tasks::find($id);
            $task -> tag = $request->get('value');
            $task -> save();
        }
    }

    /**
     * Детальная страница задача
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showTaskById($request)
    {
        $task = Tasks::find($request);

        if ($task->lawyer == Auth::user()->id) {
           $task->new = 0;
           $task->save();
        }

        return view('tasks/taskById', ['data' => Tasks::find($request)], ['datalawyers' => User::all()]);
    }

    /**
     * Редактирование задачи
     * @param int $id
     * @param TasksRequest $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editTaskById(int $id, TasksRequest $req)
    {
        $task = Tasks::find($id);

        $task->name = $req->nameoftask;
        $task->client = $req->client;
        $task->date = $req->date;
        $task->lawyer = $req->lawyer;
        $task->duration = $req->duration;
        $task->status = $req->status;
        $task->deal_id = ($req->deals !== null) ? $req->deals : null;

        if($req->tag){$task->tag = $req->tag;};
        if($req->postanovshik){$task->postanovshik = $req->postanovshik;};
        if($req->soispolintel){$task->soispolintel = $req->soispolintel;};
        if($req->description){$task->description = $req->description;};

        if($req->hrftodcm){$task->hrftodcm = $req->hrftodcm;};
        if($req->type){$task -> type = $req->type;};
        if($req->clientidinput){$task->clientid = $req->clientidinput;};

        $task->save();

        if ($task->status === 'выполнена') {
            TaskCompleted::dispatch($task);
        }

        return redirect()->route('showTaskById', $id)->with('success', 'Все в порядке, событие обновлено');
    }

    /**
     * Удаление задачи
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id)
    {
        Tasks::find($id)->delete();

        return redirect()->route('tasks')->with('success', 'Все в порядке, задача удалена');
    }

    /**
     * Получить список дел у клиента и сгенерировать выпадающий список
     * @param Request $request
     * @return string|null
     */
    public function getDealsByClient(Request $request): ?string
    {
        $client = ClientsModel::find($request->input('clientId'));
        $taskId = $request->input('taskId');
        $task = ($taskId !== null) ? Tasks::find($taskId) : null;
        $deals = $client->deals();
        $html = null;

        if ($deals->count() > 0) {
            $html = view('deal/_select_list', compact('deals', 'task'));
            return $html;
        }

        return $html;
    }
}
