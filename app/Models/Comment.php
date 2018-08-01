<?php

namespace App\Models;

use Cerbero\QueryFilters\FiltersRecords;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Comment extends Model
{
    use FiltersRecords;

    protected $table = 'comentario';
    protected $primaryKey = 'id';

    public static $apiFormat = [
        'data' => [
            'type' => 'comentario',
            'id' => 'id',
            'attributes' => [
                'contenido' => 'contenido',
                'fecha_creacion' => 'created_at',
                'fecha_modificacion' => 'updated_at',
            ],
            'relationships' => [
                'publicacion' => 'publicacion_id',
                'usuario' => 'usuario_id',
                'estado' => 'estado_id'
            ]
        ],
        'include' => [
            'user' => 'App\User',
            'status' => 'App\Models\EntitiesStatus',
            'responses' => 'App\Models\Comment',
        ],
    ];

    public function post() {
    	return $this->belongsTo('App\Models\Post', 'publicacion_id', 'id');
    }

    public function user() {
    	return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function responses() {
        return $this->hasMany('App\Models\Comment', 'respuesta_id', 'id');
    }

    public function status () {
        return $this->belongsTo('App\Models\EntitiesStatus', 'estado_id', 'id');
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
