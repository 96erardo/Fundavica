<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Comment extends Model
{
    protected $table = "comentario";
    protected $primaryKey = "id";

    public function post() {
    	return $this->belongsTo('App\Models\Post', 'publicacion_id', 'id');
    }

    public function user() {
    	return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function responses() {
        return $this->hasMany('App\Models\Comment', 'respuesta_id', 'id');
    }

    public function isPublic() {
        if($this->estado_id == 2) 
            return true;
        
        return false;
    }

    public function isHidden() {
        if($this->estado_id == 1) 
            return true;
        
        return false;
    }

    public function hide() {
        $this->estado_id = 1;
    }

    public function show() {
        $this->estado_id = 2;
    }
}
