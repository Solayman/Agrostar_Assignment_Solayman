<?php

use Illuminate\Database\Seeder;
use Database\Factories\NewsFactory;

class DatabaseSeeder extends Seeder
{
   
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         // $this->call(appointment_table::class);
        // $this->call(ForumCategorySeeder::class);
         // $this->call(ForumTopicSeeder::class);
          $this->call(ForumCommentSeeder::class);
    }
}
