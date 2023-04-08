<?php

namespace App\Http\Controllers;

use App\Models\Dogovor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ClientsModel;
use App\Models\Services;
use ZipArchive;

class DogovorController extends Controller{

    public function dogovor(){
        $avg = Dogovor::avg('allstoimost');

        return view ('dogovor/dogovor', ['data' => Dogovor::orderByDesc('created_at')->get()], ['avg' => $avg, 'dataservice' =>  Services::all(), 'datalawyers' =>  User::all(), 'dataclients' =>  ClientsModel::all()]);
    }

    public function showdogovorById($id){
        return view ('dogovor/showdogovorById', ['data' => Dogovor::with('userFunc', 'clientFunc')->find($id)], ['datalawyers' =>  User::all()
        ]);
      }

    public function adddogovor(Request $req){
        $Dogovor = new Dogovor();
            $name = $req -> input('name');
            $clientname = $req -> input('client');
            $predoplata = $req -> input('predoplata');
            $today= Carbon::now()->toDateString(); // дата без времени
            $todaywithmin = Carbon::now();
            $ispolnitel = 'Адвокатский кабинет Мина Марк Анатольевич';
            $adresispolnitelya = '295000, РФ, Респ. Крым, ул. Долгоруковская 13а';
            $kontaktyispolnitelya ='+7978 8838 978';
            $adress = $req -> input('adress');
            $phone = $req -> input('phone');
            $uslugi = $req -> input('subject');
            $allstoimost = $req -> input('allstoimost');
            $preduslugi = $req -> input('preduslugi');

            $dogovorurl = 'dogovors/'.$name.' - '.$todaywithmin.'.docx';
            $dogovorurldb = 'public/'.$dogovorurl;

                $Dogovor -> name = $name;
                $Dogovor -> allstoimost = $req -> input('allstoimost');
                $Dogovor -> preduslugi = $req -> input('preduslugi');
                $Dogovor -> predoplata = $req -> input('predoplata');
                $Dogovor -> subject = $req -> input('subject');
                $Dogovor -> client_id = $req -> input('clientidinput');
                $Dogovor -> lawyer_id = Auth::id();
                $Dogovor -> date =  $today;
                $Dogovor -> url =  $dogovorurl;
        $Dogovor -> save();

        $id = $req -> input('clientidinput');

        $client = ClientsModel::find($id);
            if(!is_null($req -> input('adress'))) {$client -> address = $adress;}
            if(!is_null($req -> input('client'))) {$client -> name =  $clientname;}
            if(!is_null($req -> input('phone'))) {$client -> phone =  $phone;}
        $client -> save();

        $Rekvizitydogovora = array(
            'field_calendar', 'field_ispolnitel', 'field_adresispolnitelya', 'field_kontaktyispolnitelya', 'field_fio',
            'field_addres', 'field_phone', 'field_uslugi', 'field_allstoimost', 'field_preduslugi', 'field_predoplata');

        $Rekvizitydogovoravar = array(
            $today, $ispolnitel, $adresispolnitelya, $kontaktyispolnitelya, $clientname,
            $adress, $phone, $uslugi, $allstoimost, $preduslugi, $predoplata);

       $psthxml = public_path('dogovor-template/document.xml');

       $tmpFile = storage_path('app/public/dogovor/soglashenie.docx');

        $zip = new ZipArchive;//пакуем в архив наши переменные
				if($zip->open($tmpFile) === TRUE) {
					$handle = fopen($psthxml, "r");
					$content = fread($handle, filesize($psthxml));
					fclose($handle);
					$content = str_replace($Rekvizitydogovora, $Rekvizitydogovoravar, $content);
					$zip->deleteName('word/document.xml');
					$zip->addFromString('word/document.xml',$content);
					$zip->close();
				}

	        $file = ($tmpFile);	//мы уже заменили содержиое файла на сервере
            header ("Content-Type: application/octet-stream");
            header ("Accept-Ranges: bytes");
            header ("Content-Length: ".filesize($file));
            header ("Content-Disposition: attachment; filename=".$name.".docx");
            //flush();  //очищение буфера вывода

        copy($file, $dogovorurl);  //копируем обработанный договор в общую папку
        session()->flash('url', $dogovorurldb);
        return redirect() -> route('dogovor') -> with('success', 'Все в порядке, договор добавлен ');
    }
}
