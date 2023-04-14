<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\User;
use App\Http\Requests\DealRequest;

class DealController extends Controller
{
    /**
     * @param DealRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DealRequest $request)
    {
        $deal = Deal::new($request);
        $deal->save();

        return redirect()->back()->with('success', 'Все в порядке, дело добавлено');
    }

    /**
     * Детальная страница дела
     * @param int $id
     * @return mixed
     */
    public function show(int $id)
    {
        $deal = Deal::find($id);
        $datalawyers = User::all();

        return view('deal/deal_by_id', compact('deal','datalawyers'));
    }

    /**
     * Редактирование дела
     * @param int $id
     * @param DealRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $id, DealRequest $request)
    {
        $deal = Deal::find($id);
        $deal->edit($request);
        $deal->save();

        return redirect()->route('deal.show', $id)->with('success', 'Все в порядке, дело обновлено');
    }

    /**
     * Удаление дела
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id)
    {
        Deal::find($id)->delete();

        return redirect()->route('clients')->with('success', 'Все в порядке, дело удалено');
    }
}
