<?php
// namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades;
use Carbon\Carbon;
use Faker\Factory as Faker;
class accounts_seeder extends Seeder
{
public function run()
{
	// password 12345678
$faker=Faker::create();

	DB::table('accounts')->insert([
	'name'=>'Agrostar',
	'email'=>'admin@Agrostar.com.bd',
	'password'=> '$2y$10$7egEyHrpPDYwjUL7lmQrzOjSLRpaRewMEawZgi7Eq/tLqxv61K0kS',
	'Admin'=>3,
	'created_at'=>Carbon::now(),
	'updated_at'=>Carbon::now(),
]);

}
}