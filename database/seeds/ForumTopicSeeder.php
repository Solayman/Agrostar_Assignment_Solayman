<?php
// namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades;
use Carbon\Carbon;
use Faker\Factory as Faker;
class ForumTopicSeeder extends Seeder
{
public function run()
{
$faker=Faker::create();
	foreach(range(1,30) as $index){
		DB::table('forum_topic')->insert([
	'forum_topic_title'=>$faker->paragraph(1),
	'forum_category_id'=>rand(1,20),
	'forum_topic_status'=>rand(1,4),
	'forum_url'=>Str::random(10).'_'.time(),
	'created_at'=>Carbon::now(),
	'updated_at'=>Carbon::now(),
]);
}
}
}