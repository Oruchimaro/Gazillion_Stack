<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable =
    [
        'body',
        'user_id'
    ];

    /***************************************Relations **************************************/
    public function question()
    {
        return $this->belongsTo(Question::class);
    }  


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes ()
    {
        return $this->morphToMany(User::class, 'votable');
    }



    /***************************************Helpers **************************************/

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

        static::deleted(function($ans){
            $question = $ans->question;
            $question->decrement('answers_count');
            if($question->best_answer_id === $ans->id )
            {
                $question->best_answer_id = NULL;
                $question->save();
            }
        });
    }





    public function getBodyHtmlAttribute ()
    {
        return \Parsedown::instance()->text($this->body);
    }



    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();  //created_at is a carbon instance, so diffForHumans or format("d/m/Y") will work
    }



    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }


    public function getIsBestAttribute()
    {
        return $this->isBest();
        
    }

    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }

    
}
