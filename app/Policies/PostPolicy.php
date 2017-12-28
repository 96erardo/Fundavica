<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function create(User $user) {
        return $user->tipo !== 3;
    }

    public function update(User $user, Post $post) {
        return $user->id === $post->usuario_id;
    }

    public function delete(User $user, Post $post) {
        return ($user->id === $post->usuario_id) || ($user->tipo == 1);
    }

    public function hide(User $user) {
        return $user->tipo !== 3;
    }

    public function show(User $user) {
        return $user->tipo !== 3;
    }
}
