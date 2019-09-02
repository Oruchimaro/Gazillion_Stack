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
    /**mutator for setting the slug as title */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);  //str_slug converts string to slug format{lowercase with dash seperator}
    }
    
}
