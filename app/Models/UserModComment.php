<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModComment extends Model
{
    protected $table = 'u_modifica_c';
    protected $primaryKey = 'created_at';
    public $timestamps = false;
    public $incrementing = false;

    public function user () {
        return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function comment () {
        return $this->belongsTo('App\Models\Comment', 'comentario_id', 'id');
    }

    public function operation () {
        return $this->belongsTo('App\Models\Operation', 'operacion_id', 'id');
    }
}
