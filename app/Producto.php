<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "producto";
    protected $primaryKey = "idP";
    public $timestamps = false;

    protected $fillable = ['nombreP','precioP', 'tipo_id', 'marca_id'];

    public function barberias()
    {
        return $this->belongsToMany('App\Barberia','barberia_producto', 'producto_idP');
    }
   

    public function tipos()
    {
        return $this->belongsToMany('App\Tipo', 'idT');
    }

    public function asignarBarberia($barberia){ 
        
        $this->barberias()->attach($barberia);
   }

    public function asignarTipo($tipo){ 

        $this->tipos()->sync($tipo,false);
    }
    
    public function marcas(){
        return $this->hasMany('App\Marca', 'idM');
    }
}