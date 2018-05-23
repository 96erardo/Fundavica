<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "role";
    public $timestamps = false;

    public static $apiFormat = [
        'data' => [
            'type' => 'role',
            'id' => 'id',
            'attributes' => [
                'nombre' => 'nombre',
            ],
            'relationships' => []
        ],
        'include' => [],
    ];
}
