<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ClientsModel;
use App\Models\LawyersModel;
use App\Models\Leads;
use App\Models\Meetings;
use App\Models\Tasks;
use App\Models\Payments;
use App\Models\Dogovor;
use App\Models\Services;
use App\Models\User;
use Carbon\Carbon;

  class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $req){

      $tasks = Tasks::where('lawyer', Auth::user()->id)-> get();
        foreach($tasks as $el){
          //dd([$el -> date][0]['value']);
          //dd(Carbon::today());
          //dd(Carbon::now()->gte([$el -> date][0]['value']));
          if(Carbon::now()->gte([$el -> date][0]['value']) && $el -> status != 'выполнена'){
            //dd('test');
          //if(Carbon::today()->eq([$el -> date][0]['value'])){
            $el -> status = 'просрочена';
            $el -> save();
        }
     }


      if($req -> input('lawyer')){
        $crtuser = $req -> input('lawyer');
      }
      else{
        $crtuser = Auth::user()->id;
      }

      if($req -> input('date')){
        if($req -> input('date') == 'month'){
          $where = 'whereMonth';
        }
        else{
          $where = 'whereDate';
        }
      }
      else{
        $where = 'whereDate';
      }

        return view('home', [
            'user' => Auth::user(),
            'data' =>
          [
            'clients' => ClientsModel::with('userFunc')
              -> where('lawyer', $crtuser)
              -> count(),
            'leads' => Leads::with('userFunc')
              -> where('lawyer', $crtuser)
              -> count(),
            'meeting' => Meetings::with('userFunc')
              -> where('lawyer', $crtuser)
              -> count(),
            'tasks' => Tasks::with('userFunc')
              -> where('lawyer', $crtuser)
              -> count(),
            'paymentsseller' => Payments::where('nameOfSeller', $crtuser)
              -> $where('created_at', (Carbon::today()))
              -> sum('SallerSalary'),
            'paymentsmodifyseller' => Payments::where('nameOfSeller', $crtuser)
            -> $where('created_at', (Carbon::today()))
              -> sum('modifySeller'),
            'paymentsattr' => Payments::where('nameOfAttractioner', $crtuser)
            -> $where('created_at', (Carbon::today()))
              -> sum('AttaractionerSalary'),
            'paymentsmodifyattr' => Payments::where('nameOfAttractioner', $crtuser)
            -> $where('created_at', (Carbon::today()))
              -> sum('modifyAttraction'),
            'paymentsdev' => Payments::where('directionDevelopment', $crtuser)
            -> $where('created_at', (Carbon::today()))
              -> sum('DeveloperSalary'),
            'datalawyers' =>  User::all()
            ],
          ],

          ['all' =>
            ['allclients' => ClientsModel:: where('lawyer', $crtuser)
              -> $where('created_at', (Carbon::today()))
              -> get(),
              'alltasks' => Tasks::where('lawyer', $crtuser)
              -> $where('created_at', (Carbon::today()))
              -> get(),
              'alltaskstoday' => Tasks::where('lawyer', $crtuser)
              -> $where('date', (Carbon::today()))
              -> get(),
              'alltaskstime' => Tasks::where('lawyer', $crtuser)
              -> where('status', 'просрочена')
              -> get(),
              'alltasksnew' => Tasks::where('lawyer', $crtuser)
              -> where('new', 1)
              -> get(),
              'allpayments' => Payments::where('nameOfAttractioner', $crtuser)
              -> $where('created_at', (Carbon::today()))
              -> get(),
              'alldogovors' => Dogovor::where('lawyer_id', $crtuser)
              -> $where('created_at', (Carbon::today()))
              -> get(),
              'allleads' => Leads::where('lawyer', $crtuser)
              -> $where('created_at', (Carbon::today()))
              -> get(),
              'allleadsoverdue' => Leads::where('lawyer', $crtuser)
              -> $where('created_at', '<', (Carbon::today()))
              -> where('status', 'поступил')
              -> get(),
            ]
         ]

      );

    }

  }
