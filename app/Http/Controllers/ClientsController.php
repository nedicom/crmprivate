<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientsRequest;
use App\Models\ClientsModel;
use App\Models\User;
use App\Models\Tasks;
use App\Models\Source;
use App\Models\Services;
use App\Repository\ClientRepository;

class ClientsController extends Controller
{
    private $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Список клиентов
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $checkedlawyer = $statusclient = $lawyertask = null;

        if (!empty($request->status)) { $statusclient = 'status'; }
        if (!empty($request->checkedlawyer)) { $checkedlawyer = 'lawyer'; $lawyertask = $request->checkedlawyer; }

        // Фильтр по статусам задач
        if (!empty($request->statustask)) {
            $statusTask = $request->statustask;

            return view ('clients/clients', [
                'data' => $this->repository->getByStatusTasks($lawyertask, $statusTask, $checkedlawyer),
            ], [
                'datalawyers' => User::all(),
                'dataservices' => Services::all(),
                'datatasks' => Tasks::all(),
                'datasource' => Source::all(),
            ]);
        } else {
            return view ('clients/clients', [
                'data' => $this->repository->getByClientAndLawyer($request, $checkedlawyer, $statusclient),
            ], [
                'datalawyers' => User::all(),
                'dataservices' => Services::all(),
                'datasource' => Source::all(),
            ]);
        }
    }

    public function show(int $id)
    {
        $client =  $this->repository->findById($id);

        return view ('clients/clientbyid', [
            'data' => $client,
        ], [
            'datalawyers' =>  User::all(),
            'datasource' => Source::all(),
        ]);
    }

    public function store(ClientsRequest $request)
    {
        $client = ClientsModel::new($request);
        $client->saveOrFail();

        return redirect()->route('clients')->with('success', 'Все в порядке, клиент добавлен');
    }

    public function update(int $id, ClientsRequest $request)
    {
        $client = ClientsModel::find($id);
        $client->edit($request);
        $client->save();

        return redirect()->route('showClientById', $id)->with('success', 'Все в порядке, клиент обновлен');
    }

    public function delete(int $id)
    {
        $client = ClientsModel::find($id);
        $client->status = null;
        $client->save();

        return redirect()->route('clients')->with('success', 'Все в порядке, клиент удален (не в работе)');
    }
}
