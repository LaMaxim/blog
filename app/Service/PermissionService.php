<?php

namespace App\Service;

use App\Post;
use Illuminate\Support\Facades\Auth;

class PermissionService
{
    /**
     * @param array $allow
     * @param Post $post
     * @return bool
     */
    public function allowEditElements($allow = [], Post $post) {

        if (Auth::user()) {
            $user = Auth::user();
            $userRole = $user->roles->first()->name;

            if (empty($allow)) {
                return false;
            }

            if (in_array('owner', $allow) && ($user->id == $post->users()->first()->id)) {
                return true;
            }

            return in_array($userRole, $allow);
        } else {

        }

    }

    /**
     * @param Post $post
     * @return bool
     */
    public function canEditAndDeletePost (Post $post) {
        $user = Auth::user();
        if ($post->users()->first()->id == $user->id || $user->roles->first()->name == 'admin') {
            return true;
        }

        return false;
    }

}
