<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TestController extends Controller
{
   
    public function test(){
        $message = 0;
        $name = DB::table('clients_models')->where('tgid', $message)->value('id');
        if(!empty($name)){
            $name = 'yes';
        }
        else{
            $name = 1;
        }
        
        return view ('test', ['data' => $name]);
    }
}
