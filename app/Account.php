<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $table = "cuenta";
    protected $primaryKey = "id";
    public $timestamps = false;
}
