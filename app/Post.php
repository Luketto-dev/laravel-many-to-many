<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $fillable = ['title', 'content', 'category_id'];

    //collegamento con il model User
    public function user(){
        return $this->belongsTo("App\User");
    }

    //collegamento con il model category
    public function category(){
        return $this->belongsTo("App\Category");
    }

    //collegamento con il model tag
    public function tags(){
        return $this->belongsToMany("App\Tag");
    }
}
