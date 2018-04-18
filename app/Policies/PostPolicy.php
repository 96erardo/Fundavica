<?php

namespace App\Policies;

use App\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function create(User $user) {
        return $user->role_id >= 3;
    }

    public function update(User $user, Post $post) {
        return $user->id == $post->usuario_id;
    }

    public function delete(User $user, Post $post) {
        return ($user->id == $post->usuario_id) || $user->isAdmin();
    }

    public function hide(User $user) {
        return $user->role_id >= 3;
    }

    public function show(User $user) {
        return $user->role_id >= 3;
    }
}
