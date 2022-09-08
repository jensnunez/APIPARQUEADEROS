<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioVehiculo extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'user_vehiculo';

    protected $fillable = ['placa_id','user_id'];

    public function vehiculo()
    {
        return $this->hasMany('App\Models\Vehiculo', 'id', 'placa_id');
    }

    public function user()
    {
        return $this->hasMany('App\Models\User', 'id', 'user_id');
    }

}
