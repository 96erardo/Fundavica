<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntitiesStatus extends Model
{
    protected $table = 'estado_otros';
    public $timestamps = false;

    public static $apiFormat = [
        'data' => [
            'type' => 'estado',
            'id' => 'id',
            'attributes' => [
                'nombre_visible' => 'contenido',
            ],
            'relationships' => []
        ],
        'include' => [],
    ];
}
