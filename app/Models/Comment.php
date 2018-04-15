<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	//
    protected $table = "comentario";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function post() {
    	return $this->belongsTo('App\Models\Post', 'publicacion_id', 'id');
    }

    public function user() {
    	return $this->belongsTo('App\User', 'usuario_id', 'id');
    }
}
