<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades;
use Carbon\Carbon;
use Faker\Factory as Faker;
class volunteer_table extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
$faker=Faker::create();
foreach(range(1,50) as $index){
DB::table('volunteer')->insert([
'name'=>$faker->name,
'email'=>$faker->unique()->safeEmail,
'address'=>$faker->paragraph(1),
'phone'=>$faker->phoneNumber,
'message'=>$faker->paragraph(2),
'blood_group'=>$faker->paragraph(1),
'nid_number'=>rand(1000000,9999999),
'created_at'=>Carbon::now(),
'updated_at'=>Carbon::now(),
]);
}
}
}