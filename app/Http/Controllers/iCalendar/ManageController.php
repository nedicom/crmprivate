<?php

namespace App\Http\Controllers\iCalendar;

//use App\Services\Calendar\GenerateCalendar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\Tasks;

class ManageController extends Controller
{
    /*private  $service;

    public function __construct(GenerateCalendar $service)
    {
        $this->service = $service;
    } */

    /**
     * Создание календаря
     * @return void
     */
    /*public function create()
    {
        $this->service->createTaskCalendar(new Tasks());
    }*/

    /**
     * Просмотр календаря
     */
    public function browse(int $userID): string
    {
        $dir = storage_path("app/public/calendar/user_{$userID}");
        $filename = $dir .  "/calendar.ics";
        $file = file_get_contents($filename);

        header('Content-type: text/calendar; charset=utf-8');

        return $file;
    }
}
