<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModPost extends Model
{
    protected $table = 'u_modifica_p';
    protected $primaryKey = 'created_at';
    public $timestamps = false;
    public $incrementing = false;

    public function user () {
        return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function post () {
        return $this->belongsTo('App\Models\Post', 'publicacion_id', 'id');
    }

    public function operation () {
        return $this->belongsTo('App\Models\Operation', 'operacion_id', 'id');
    }
}
