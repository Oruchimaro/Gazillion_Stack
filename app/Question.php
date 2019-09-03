<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
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

    /***************************************Helpers **************************************/

    /**these accessors help format Elquent attribytes when we retrive them from model instances*/
    public function getUrlAttribute()
    {
        return route('questions.show', $this->id);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();  //created_at is a carbon instance, so diffForHumans or format("d/m/Y") will work
    }

    public function getStatusAttribute ()
    {
        if( $this->answers > 0 )
        {
            if($this->best_answer_id)
            {
                return "answer-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    /**mutator for setting the slug as title */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);  //str_slug converts string to slug format{lowercase with dash seperator}
    }


}//End of model
