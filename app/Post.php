<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = "publicacion";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function user(){
    	return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function category(){
    	return $this->belongsTo('App\Category', 'categoria_id', 'id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'publicacion_id', 'id');
    }
}
