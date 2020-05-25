<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content','image_file','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function favorite_user()
    {
        return $this->belongsToMany(User::class,'micropost_favorite','micropost_id','user_id')->withTimestamps();
    }
    
}
