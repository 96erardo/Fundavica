<?php

namespace App\Policies;

use App\User;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Comment $comment) {
        return $user->id == $comment->usuario_id;
    }

    public function delete(User $user, Comment $comment) {
        return ($user->isAdmin() || $user->id == $comment->usuario_id);
    }
}
