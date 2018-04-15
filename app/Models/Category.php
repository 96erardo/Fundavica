<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categoria";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function posts(){
    	return $this->hasMany('App\Models\Posts', 'categoria_id', 'id');
    }
}
