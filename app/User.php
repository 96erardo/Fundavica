<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'nombre', 'apellido', 'usuario', 'correo', 'clave', 'role_id', 'estado_id'
    ];

    public static $apiFormat = [
        'data' => [
            'type' => 'usuario',
            'id' => 'id',
            'attributes' => [
                'nombre' => 'nombre',
                'apellido' => 'apellido',
                'correo' => 'correo',
                'usuario' => 'usuario',
            ],
            'relationships' => [
                'role' => 'role_id',
                'status' => 'estado_id',
            ]
        ],
        'include' => [
            'role' => 'App\Models\Role',
            'status' => 'App\Models\UserStatus',
        ],
    ];

    public function posts () {
        return $this->hasMany('App\Models\Posts', 'usuario_id', 'id');
    }

    public function role () {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function status () {
        return $this->belongsTo('App\Models\UserStatus', 'estado_id', 'id');
    }

    /**
     * Boost the model 
     */
    public static function boot() {
        parent::boot();

        static::creating(function($user){
            $user->verifyme_token = str_random(40);
        });
    }

    /**
     * verifies the user email
     */
    public function hasVerified() {

        $this->estado_id = 2;
        $this->verifyme_token = null;

        $this->save();
    }

    public function getAuthPassword() {
        return $this->clave;
    }

    public function getEmailForPasswordReset(){
        return $this->correo;
    }

    public function getType() {
        if($this->role_id == 4)
            return "Administrador";
        if($this->role_id == 3)
            return "Redactor";
        if($this->role_id == 2 || $this->role_id == 1)
            return "Estandar";
    }
    
    /**
     * Returns wheter the authenticated user has the normal role or not
     *
     * @return boolean
     */
    public function isNormal() {
        if($this->role_id == 2 || $this->role_id == 1)
            return true;

        return false;
    }

    /**
     * Returns wheter the authenticated user has the writer role or not
     *
     * @return boolean
     */
    public function isWriter() {
        if($this->role_id == 3)
            return true;

        return false;
    }

    /**
     * Returns wheter the authenticated user has the admin role or not
     *
     * @return boolean
     */
    public function isAdmin() {
        if($this->role_id == 4)
            return true;

        return false;
    }

    /**
     * Returns wheter user has an active account or not
     *
     * @return boolean
     */
    public function isActive() {
        if($this->estado == 1)
            return true;

        return false;
    }

    /**
     * Returns wheter this user account was once deleted
     *
     * @return boolean
     */
    public function isDeleted() {
        if($this->deleted_at == null)
            return false;
        
        return true;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
