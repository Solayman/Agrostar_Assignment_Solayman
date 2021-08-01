<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades;
use Carbon\Carbon;
use Faker\Factory as Faker;

class appointment_table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker=Faker::create();
    	foreach(range(1,100) as $index){

    		 DB::table('doctor_appointment')->insert([
        	'customer_id'=>rand(50,100),
        	'date_id'=>500,
        	// 'session_name'=>Str::random(10),
            'session_name'=>$faker->name,
        	'applicant_name'=>$faker->name,
        	'contact_number'=>$faker->phoneNumber,
        	'email'=>$faker->unique()->safeEmail,
        	'start_time'=>Carbon::now()->subMinutes(rand(1, 55)),
        	'end_time'=>Carbon::now()->subMinutes(rand(1, 55)),
        	'date'=>Carbon::now()->subMinutes(rand(1, 55)),
        	'description'=>$faker->paragraph(3),
        	'appointment_status'=>rand(0,2),
        	'created_at'=>Carbon::now(),
        	'updated_at'=>Carbon::now(),

        ]);
    	}
       
    }
}
