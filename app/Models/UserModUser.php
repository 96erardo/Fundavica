<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModUser extends Model
{
    protected $table = 'u_modifica_u';
    protected $primaryKey = 'created_at';
    public $timestamp = false;
    public $incrementing = false;

    public function updater () {
        return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function updated () {
        return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function operation () {
        return $this->belongsTo('App\Models\Operation', 'operacion_id', 'id');
    }
}
