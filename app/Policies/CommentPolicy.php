<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Comment $comment) {
        return $user->id == $comment->usuario_id;
    }

    public function delete(User $user, Post $post, Comment $comment) {
        return ($user->tipo != 1 || $user->id == $comment->usuario_id);
    }
}
