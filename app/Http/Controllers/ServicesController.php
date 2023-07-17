<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Http\Requests\ServicesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repository\ServiceRepository;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    private $repository;

    public function __construct(ServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return view ('services', [
            'data' => Services::all(),
        ]);
    }

    /**
     * @param ServicesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(ServicesRequest $request)
    {
        $service = new Services();
        $service->fill($request->except('_token'));
        $service->saveOrFail();

        return redirect()->route('services.index')->with('success', 'Все в порядке, услуга добавлена');
    }

    public function update(ServicesRequest $request, Services $service)
    {
        $service->fill($request->except('_token'));
        $service->update();

        return back()->with('success', 'Услуга была успешно обновлена.');
    }

    public function destroy(Services $service)
    {
        $service->delete();

        return back()->with('success', 'Услуга была успешно удалена.');
    }

    /**
     * Рендер формы редактирования через ajax запрос
     * @param Services $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxEdit(Services $service)
    {
        $html = View::make('inc/modal/_part-edit-service', compact('service'))->render();

        return response()->json([
            'content' => $html,
        ]);
    }

    /**
     * Подгрузка списка услуг по Ajax запросу
     */
    public function ajaxList(Request $request)
    {
        $services = $this->repository->getAll();
        $html = View::make('inc/modal/_part-edit-task', compact('services'))->render();

        return response()->json([
            'content' =>  $html,
        ]);
    }

    /**
     * Данные сущности Services через ajax запрос
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxElement(Request $request)
    {
        $id = $request->only(['serviceId']);
        $validator = Validator::make($id, [
            'serviceId' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Пожвлуйста проверьте значение service_id'
            ]);
        }
        $service = Services::find($id)->first();

        return response()->json([
            'success' => true,
            'id' => $service->id,
            'name' => $service->name,
            'duration' => $service->execution_time,
        ]);
    }

    /**
     * Поиск через фильтр по Ajax запросу
     * @param string $query
     * @return mixed
     */
    public function ajaxSearch(Request $request)
    {
        $services = $this->repository->getByNames($request->query('query'));
        $html = View::make('inc/modal/_list-services', compact('services'))->render();

        return response()->json([
            'content' => $html,
        ]);
    }
}
