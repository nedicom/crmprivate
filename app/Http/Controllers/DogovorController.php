<?php

namespace App\Http\Controllers;

use App\Models\Dogovor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClientsModel;
use App\Models\Services;
use Illuminate\Support\Facades\File;
use App\Services\ContractsService;

class DogovorController extends Controller
{
    private $service;

    public function __construct(ContractsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $avg = Dogovor::avg('allstoimost');

        return view('dogovor/dogovor', [
            'data' => Dogovor::orderByDesc('created_at')->get()
        ], [
            'avg' => $avg,
            'dataservice' => Services::all(),
            'datalawyers' => User::all(),
            'dataclients' => ClientsModel::all(),
        ]);
    }

    public function showdogovorById($id)
    {
        return view('dogovor/showdogovorById', [
            'data' => Dogovor::with('userFunc', 'clientFunc')->find($id)
        ], [
            'datalawyers' => User::all(),
        ]);
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $today = Carbon::now()->toDateString(); // Дата без времени
        $contractUrl = 'dogovors/'.$name.' - '. Carbon::now() .'.docx';

        try {
            $contacts = $this->service->new($today, $contractUrl, $request);
            if (!empty($contacts)) {
                $file = $this->service->attachFile($contractUrl, $today, $request);
            }
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('contracts.index')
            ->withHeaders([
                'Content-Type' => 'application/octet-stream',
                'Accept-Ranges' => 'bytes',
                'Content-Length' => File::size($file),
                'Content-Disposition' => "attachment; filename=".$name.".docx",
            ])
            ->with('success', "Все в порядке, договор $contacts->name добавлен");
    }
}
