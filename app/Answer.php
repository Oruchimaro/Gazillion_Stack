<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /***************************************Relations **************************************/
    public function question()
    {
        return $this->belongsTo(Question::class);
    }  


    public function user()
    {
        return $this->belongsTo(User::class);
    }



    /***************************************Helpers **************************************/
    public function getBodyHtmlAttribute ()
    {
        return \Parsedown::instance()->text($this->body);
    }



    /**this will be run on any instance of Answer model, 
     * so when create method is called it will increament the answers_count column in questions table.
     */
    public static function boot()
    {
        parent::boot();
        static::created(function($answer){
            $answer->question->increment('answers_count');
            // $answer->question->save(); this is not needed ,it will be ran behind the scene
        });
    }
}
