<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\User;
use App\Models\Services;
use App\Models\Source;
use Illuminate\Http\Request;
use App\Http\Requests\LeadsRequest;
use App\Models\ClientsModel;

class LeadsController extends Controller
{
    public function addlead(LeadsRequest $req)
    {
        $lead = new Leads();
        $lead->name = $req->input('name');
        $lead->source = $req->input('source');
        $lead->description = $req->input('description');
        $lead->phone = $req->input('phone');
        $lead->lawyer = $req->input('lawyer');
        $lead->responsible = $req->input('responsible');
        $lead->service = $req->input('service');
        $lead->status = $req->input('status');

        $lead->save();

        return redirect() -> route('leads') -> with('success', 'Все в порядке, лид добавлен');
    }

    public function showleads(Request $req)
    {
        $lawyer = null;
        $source = null;
        $responsible = null;
        $status=$req->input('checkedstatus');

        if (!empty($req->checkedlawyer)){$lawyer='lawyer';}
        if (empty($req->checkedstatus)){$deleting='удален';}
        else {$deleting='';}
        if (!empty($req->checkedsources)){$source='source';}
        if (!empty($req->checkedresponsible)){$responsible='responsible';}

        return view ('leads/leads', ['data' => Leads::where($lawyer, $req->checkedlawyer)
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->where('status', '!=', $deleting)
            ->where($source, $req->checkedsources)
            ->where($responsible, $req->checkedresponsible)
            ->orderBy('created_at', 'desc')
            ->get()], [
                'datalawyers'  => User::active()->get(),
                'dataservices' => Services::all(), 'datasources' =>  Source::all('name'),
                'datasource'   => Source::all(),
            ]
        );
    }

    public function showLeadById($id)
    {
        return view ('leads/showLeadById', ['data' => Leads::with('userFunc',
            'responsibleFunc' , 'servicesFunc')->find($id)], [
                'datalawyers' => User::active()->get(),
                'dataservices' => Services::all(),
                'datasource' => Source::all()
            ]
        );
    }

    public function LeadUpdateSubmit($id, LeadsRequest $req)
    {
        $lead = Leads::find($id);
        $lead -> name = $req -> input('name');
        $lead -> source = $req -> input('source');
        $lead -> description = $req -> input('description');
        $lead -> phone = $req -> input('phone');
        $lead -> lawyer = $req -> input('lawyer');
        $lead -> responsible = $req -> input('responsible');
        $lead -> service = $req -> input('service');
        $lead -> save();

        return redirect() -> route('showLeadById', $id) -> with('success', 'Все в порядке, лид обновлен');
    }


    public function leadToWork($id, Request $req)
    {
        $lead = Leads::find($id);
        $lead -> status = 'в работе';
        $lead -> action = $req -> input('action');
        $lead -> save();

        return redirect() -> route('showLeadById', $id) -> with('success', 'Все в порядке, лид в работе');
    }

    public function leadToClient($id, Request $req)
    {
        $lead = Leads::find($id);

        $client = new ClientsModel();
        $client->name = $lead -> name;
        $client->phone = $lead -> phone;
        $client->email = 'email';
        $client->source = $lead -> source;
        $client->status = 1;
        $client->lawyer = $lead -> lawyer;
        $client->lead_id = $lead -> id;
        $client->save();

        $clientid = $client->id;

        $lead->status = 'конвертирован';
        $lead->successreason = $req -> input('successreason');
        $lead->client_id =  $clientid;
        $lead->save();

        return redirect()->route('showClientById', $clientid)->with('success', 'Поздравляем, лид стал клиентом');
    }

    public function leadDelete($id, Request $req)
    {
        $lead = Leads::find($id);
        $lead->status = 'удален';
        $lead->failurereason = $req -> input('failurereason');
        $lead->save();

        return redirect()->route('leads') -> with('success', 'Все в порядке, лид удален');
    }
}
