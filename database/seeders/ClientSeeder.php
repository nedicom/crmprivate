<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ClientsModel;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = ClientsModel::all();
        foreach($clients as $client){
                DB::table('clients_models')->where('id', $client->id)->update([            
                'tgid' => rand(0, 1000000),
            ]);
        }
    }
}
