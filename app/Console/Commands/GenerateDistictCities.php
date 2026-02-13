<?php

namespace App\Console\Commands;

use App\Models\State;
use DB;
use Illuminate\Console\Command;

class GenerateDistictCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-distict-cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
		//cleanup states and cities
		DB::table('states')->truncate();
		DB::table('cities')->truncate();
		$provs = DB::table('id_provinces')->get();
		foreach ($provs as $prov) {
			DB::table('states')->insert([
				'id' => $prov->id,
				'name' => $prov->name,
				'country_id' => 102,
				'status' => 1
			]);
			echo "inserted state: ".$prov->id."\n";
			//insert into cities
			$city = DB::table('id_cities')->where('province_code', $prov->code)->get();
			foreach ($city as $c) {
				DB::statement('INSERT INTO cities (id, name, state_id, status) VALUES (?, ?, ?, ?)', [
					$c->id,
					$c->name,
					$prov->id,
					1
				]);
				echo "inserted city: ".$c->id."\n";
			}
		}
    }
}
