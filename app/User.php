<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function asignarRole($role){ 
         $this->roles()->sync($role,false);
    }

    public function tieneRole(){ 
        return $this->roles->flatten()->pluck('name')->unique();
   }

   public function comentarios()
    {
        return $this->belongsTo('App\Comentario','idC');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
