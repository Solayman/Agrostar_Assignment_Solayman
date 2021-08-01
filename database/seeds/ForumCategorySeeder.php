<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Faker::create();
	foreach(range(1,30) as $index){
	DB::table('forum_category')->insert([
	'forum_category_name'=>$faker->paragraph(1),
	'forum_category_description'=>$faker->paragraph(3),
	'created_at'=>Carbon::now(),
	'updated_at'=>Carbon::now(),
]);
}
    }
}
