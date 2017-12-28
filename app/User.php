<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'apellido', 'usuario', 'correo', 'clave',
        'tipo', 'estado', 'remember_token', 'deleted_at', 'token'
    ];

    public function posts(){
        return $this->hasMany('App\Posts', 'usuario_id', 'id');
    }

    /**
     * Boost the model 
     */
    public static function boot() {
        parent::boot();

        static::creating(function($user){
            $user->token = str_random(40);
        });
    }

    /**
     * verifies the user email
     */
    public function hasVerified() {

        $this->verified = true;
        $this->token = null;

        $this->save();
    }

    public function getAuthPassword() {
        return $this->clave;
    }

    public function getEmailForPasswordReset(){
        return $this->correo;
    }

    public function getType() {
        if($this->tipo == 1)
            return "Administrador";
        if($this->tipo == 2)
            return "Redactor";
        if($this->tipo == 3)
            return "Estandar";
    }

    public function isActive() {
        if($this->estado == 1)
            return true;

        return false;
    }

    public function isDeleted() {
        if($this->deleted_at == null)
            return false;
        
        return true;
    }
}
