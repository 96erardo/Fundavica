<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cerbero\QueryFilters\FiltersRecords;

class Post extends Model
{
    use FiltersRecords;

    protected $table = 'publicacion';

    protected $primaryKey = 'id';

    public static $apiFormat = [
        'data' => [
            'type' => 'publicacion',
            'id' => 'id',
            'attributes' => [
                'titulo' => 'titulo',
                'imagen' => 'imagen',
                'contenido' => 'contenido',
            ],
            'relationships' => [
                'categoria' => 'categoria_id',
                'usuario' => 'usuario_id',
                'estado' => 'estado_id'
            ]
        ],
        'include' => [
            'user' => 'App\User',
            'category' => 'App\Models\Category',
            'status' => 'App\Models\EntitiesStatus',
            'comments' => 'App\Models\Comment',
        ],
    ];

    public function user(){
    	return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function category(){
    	return $this->belongsTo('App\Models\Category', 'categoria_id', 'id');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment', 'publicacion_id', 'id');
    }

    public function status () {
        return $this->belongsTo('App\Models\EntitiesStatus', 'estado_id', 'id');
    }

    public function hide() {
        $this->estado_id = 1;
    }

    public function show() {
        $this->estado_id = 2;
    }
}
