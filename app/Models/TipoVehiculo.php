<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVehiculo extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'tipo_vehiculos';

    protected $fillable = ['descripcion'];

    public function vehiculo() {
        return $this->belongsTo(Vehiculo::class);
    }


	
}
