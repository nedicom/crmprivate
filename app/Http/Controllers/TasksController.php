<?php

namespace App\Http\Controllers;

use App\Events\Task\TaskCompleted;
use App\Events\Task\TaskCreated;
use App\Models\ClientsModel;
use Illuminate\Http\Request;
use App\Http\Requests\TasksRequest;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Repository\TaskRepository;

class TasksController extends Controller
{
    private $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $lawyerfilter = $typefilter = null;
        $checkedlawyer = $type = null;
        $calendar = $request->input('calendar'); // Month, year, day
        if ($request->input('checkedlawyer')) { $lawyerfilter = 'lawyer'; $checkedlawyer = $request->input('checkedlawyer'); } // Lawyer
        if ($request->input('type')) { $typefilter = 'type'; $type = $request->input('type'); } // Type
        $fields = compact('lawyerfilter','checkedlawyer', 'typefilter', 'type');

        // Фильтр по календарю
        if ($calendar == 'week') {
            return view ('tasks/tasks', [
                'data' => $this->repository->getByBetweenDate(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek(), $fields),
            ], [
                'datalawyers' => User::all()
            ]);
        } else if ($calendar == 'day') {
            return view ('tasks/tasks', [
                'data' => $this->repository->getByBetweenDate(Carbon::now()->startOfDay(), Carbon::now()->endOfDay(), $fields),
            ], [
                'datalawyers' =>  User::all()
            ]);
        } elseif ($calendar == 'month') {
              if ($request->input('months')) { // check number of monts
                  $month = ($request->input('months'));
              } else {
                  $month = ((Carbon::now()->month) - 1);
              }
              return view ('tasks/tasks', [
                  'data' => $this->repository->getByBetweenDate(Carbon::now()->startOfYear()->addMonth($month), Carbon::now()->startOfYear()->addMonth($month + 1), $fields),
              ], [
                  'datalawyers' =>  User::all()
              ]);
        } else {
            return view ('tasks/tasks', [
                'data' => $this->repository->getAll($fields),
            ], [
                'datalawyers' =>  User::all()
            ]);
        }
    }

    /**
     * Создание задачи
     * @param TasksRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(TasksRequest $request)
    {
        $task = Tasks::new($request);
        $task->saveOrFail();
        // Events
        TaskCreated::dispatch($task);

        return redirect()->back()->with('success', 'Все в порядке, задача добавлена.');
    }

    public function storeByLead(TasksRequest $request)
    {
        $task = Tasks::newFromLead($request);
        $task->saveOrFail();
        // Events
        TaskCreated::dispatch($task);

        return redirect()->back()->with('success', 'Все в порядке, задача добавлена.');
    }

    /**
     * Закрепление тега
     * @param Request $request
     * @return void
     */
    public function tag(Request $request)
    {
        if ($request->get('id')) {
            $id = $request->get('id');
            $task = Tasks::find($id);
            $task->tag = $request->get('value');
            $task->save();
        }
    }

    /**
     * Детальная страница задачи
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showTaskById($request)
    {
        /** @var Tasks $task */
        $task = Tasks::find($request);
        if ($task->lawyer == Auth::user()->id) {
           $task->new = $task::STATE_OLD;
           $task->save();
        }

        return view('tasks/taskById', ['data' => Tasks::find($request)], ['datalawyers' => User::all()]);
    }

    /**
     * Обновление задачи
     * @param int $id
     * @param TasksRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editTaskById(int $id, TasksRequest $request)
    {
        /** @var Tasks $task */
        $task = Tasks::find($id);
        $task->edit($request);
        $task->save();
        // Events
        if ($task->status === $task::STATUS_COMPLETE) {
            $task->donetime = Carbon::now();
            $task->save();
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
