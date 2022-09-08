<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'periodos';

    protected $fillable = ['descripcion'];

    public function reportes() {
        return $this->belongsTo(Reporte::class);
    }
	
}
