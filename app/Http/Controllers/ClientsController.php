<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientsRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\ClientsModel;
use App\Models\User;
use App\Models\Tasks;
use App\Models\Source;
use App\Models\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ClientsController extends Controller
{
    public function submit(ClientsRequest $req)
    {
        $client = new ClientsModel();
        $client->name = $req->input('name');
        $client->phone = $req->input('phone');
        if (!is_null($req->input('email'))) {$client->email = $req->input('email');}
        $client->source = $req->input('source');
        $client->status = $req->input('status');
        $client->lawyer = $req->input('lawyer');
        if (!is_null($req->input('address'))) {
            $client -> address = $req->input('address');
        }
        $value = rand(0, 1000000);
        $client->tgid = $value;
        $client->save();

        return redirect()->route('clients')->with('success', 'Все в порядке, клиент добавлен');
    }

    /**
     * Список клиентов
     * @param Request $req
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function AllClients(Request $req)
    {
        $checkedlawyer = $statusclient = $lawyertask = null;

        if (!empty($req->status)){$statusclient='status';}
        if (!empty($req->checkedlawyer)){$checkedlawyer='lawyer'; $lawyertask = $req->checkedlawyer;}

        // Фильтр по статусам
        if (!empty($req->statustask)) {
            $statusTask = $req->statustask;

            return view ('clients/clients', [
                'data' => ClientsModel::whereHas('tasksFunc', function (Builder $query) use ($lawyertask, $statusTask, $checkedlawyer) {
                    $query->where('status', '=', $statusTask)
                        ->where($checkedlawyer, '=',  $lawyertask);
                }, '>=', 1)->get()], [
                'datalawyers' => User::all(),
                'dataservices' => Services::all(),
                'datatasks' => Tasks::all(),
                'datasource' => Source::all(),
            ]);
        } else {
            return view ('clients/clients', [
                'data' => ClientsModel::where('name', 'like', '%'.$req->findclient.'%')
                    ->where($checkedlawyer, $req->checkedlawyer)
                    ->where($statusclient, $req->status)
                    ->get()
            ], [
                'datalawyers' => User::all(),
                'dataservices' => Services::all(),
                'datasource' => Source::all(),
            ]);
        }
    }

    public function showClientById($id)
    {
        $client = new ClientsModel();

        return view ('clients/clientbyid', ['data' => ClientsModel::with('userFunc', 'tasksFunc', 'serviceFunc', 'paymentsFunc')->find($id)],
            ['datalawyers' =>  User::all(), 'datasource' => Source::all()]
        );
    }

    public function updateClient($id)
    {
        $client = new ClientsModel();

        return view ('clients/updateClient', ['data' => $client->find($id)], ['datalawyers' =>  User::all()]);
    }

    public function updateClientSubmit($id, ClientsRequest $req)
    {
        $client = ClientsModel::find($id);
        $client->name = $req->input('name');
        $client->phone = $req->input('phone');
        if (!is_null($req->input('email'))) {$client -> email = $req -> input('email');}
        $client->source = $req->input('source');
        $client->status = $req->input('status');
        if ($req->input('status') == 'выполнена') {
            $client->status = 0;
        }
        $client->lawyer = $req->input('lawyer');
        if (!is_null($req->input('address'))) {$client->address = $req->input('address');}
        $client->save();

        return redirect()->route('showClientById', $id)->with('success', 'Все в порядке, клиент обновлен');
    }

    public function ClientDelete($id)
    {
        $client = ClientsModel::find($id);
        $client->status = null;
        $client->save();

        return redirect()->route('clients')->with('success', 'Все в порядке, клиент удален (не в работе)');
    }
}
