<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoReporte extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'tipo_reportes';

    protected $fillable = ['descripcion'];
	
}
