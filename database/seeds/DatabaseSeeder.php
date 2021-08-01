<?php
use Illuminate\Database\Seeder;
use Database\Factories\NewsFactory;
class DatabaseSeeder extends Seeder
{

public function run()
{

$this->call(accounts_seeder::class);
$this->call(volunteer_table::class);
}
}