<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'vehiculos';

    protected $fillable = ['placa','tipo_vehiculo_id','observacion'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tipoVehiculo()
    {
        return $this->hasMany('App\Models\TipoVehiculo', 'id', 'tipo_vehiculo_id');
    }
    
}
