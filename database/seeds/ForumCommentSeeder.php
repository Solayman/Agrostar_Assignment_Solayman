<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ForumCommentSeeder extends Seeder
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
	DB::table('forum_comment')->insert([
	'user_type'=>rand(0,1),
	'user_id'=>rand(1,30),
    'forum_topic_id'=>rand(1,50),
    'message'=>$faker->paragraph(5),
    'forum_comment_status'=>rand(1,3),
	'created_at'=>Carbon::now(),
	'updated_at'=>Carbon::now(),
]);
}
    }
}
