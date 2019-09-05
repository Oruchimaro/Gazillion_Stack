<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use VotableTrait;
    protected $fillable =
    [
        'title',
        'body',
    ];
    /***************************************Relations **************************************/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        /*Many to Many Relations
        *  $this->belongsToMany(Question::class, 'favorites', 'question_id', 'user_id') 
        */
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); 
    }

    /***************************************Helpers **************************************/

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }


    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count();
    }

    /**these accessors help format Elquent attribytes when we retrive them from model instances*/

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFaoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getUrlAttribute()
    {
        // return route('questions.show', $this->id);
        return route('questions.show', $this->slug); //this will return a slug instad of id
    }



    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();  //created_at is a carbon instance, so diffForHumans or format("d/m/Y") will work
    }




    public function getStatusAttribute ()
    {
        if( $this->answers_count > 0 )
        {
            if($this->best_answer_id)
            {
                return "answer-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }




    public function getBodyHtmlAttribute ()
    {
        return \Parsedown::instance()->text($this->body);
    }



    
    /**mutator for setting the slug as title */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);  //str_slug converts string to slug format{lowercase with dash seperator}
    }



}//End of model
