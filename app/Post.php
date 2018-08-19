<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'post_user', 'post_id', 'user_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }
}
