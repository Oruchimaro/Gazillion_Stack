<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use VotableTrait;  //voting partial file in /App

    protected $fillable =
    [
        'body',
        'user_id'
    ];

    protected $appends = [
        'created_date',
        'body_html'
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
        return clean(\Parsedown::instance()->text($this->body));
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

}
