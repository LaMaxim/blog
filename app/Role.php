<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    const ROLE_ADMIN = '2';
    const ROLE_USER = '1';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'role_user', 'role_id', 'user_id');
    }
}
