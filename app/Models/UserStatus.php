<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    protected $table = 'estado_usuario';
    public $timestamps = false;

    public static $apiFormat = [
        'data' => [
            'type' => 'estado',
            'id' => 'id',
            'attributes' => [
                'nombre' => 'nombre',
            ],
            'relationships' => []
        ],
        'include' => [],
    ];
}
