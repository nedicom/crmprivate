<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Http\Requests\ServicesRequest;

class ServicesController extends Controller
{
    public function addservice(ServicesRequest $req)
    {
        $service = new Services();
        $service->name = $req->input('name');
        $service->price = $req->input('price');
        $service->save();

        return redirect()->route('showservices')->with('success', 'Все в порядке, услуга добавлена');
    }

    public function showservices()
    {
        return view ('services', ['data' => Services::all()]);
    }
}
