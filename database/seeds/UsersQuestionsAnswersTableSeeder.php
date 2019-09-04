<?php

use Illuminate\Database\Seeder;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('answers')->delete();
        \DB::table('questions')->delete();  
        \DB::table('users')->delete();
        
        /**cause the questions need to be linked to a user , so it will be like this */
        factory(App\User::class, 5)->create()->each(function($u){
            $u->questions()->saveMany(factory(App\Question::class, rand(3, 10))->make())
            ->each(function($q){
                    $q->answers()->saveMany(factory(App\Answer::class, rand(3, 15))->make());
                });
        }); 
    }
}
