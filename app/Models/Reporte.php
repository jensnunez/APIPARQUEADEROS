<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table = 'reportes';

    protected $fillable = ['fecha','tipo_reporte_id','placa_id','user_id','sede_id','image','estado','periodo_id'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tipoReporte()
    {
        return $this->hasMany('App\Models\TipoReporte', 'id', 'tipo_reporte_id');
    }

    public function vehiculo()
    {
        return $this->hasMany('App\Models\Vehiculo', 'id', 'placa_id');
    }

    public function user()
    {
        return $this->hasMany('App\Models\User', 'id', 'user_id');
    }

    public function sede()
    {
        return $this->hasMany('App\Models\Sede', 'id', 'sede_id');
    }

    public function periodo()
    {
        return $this->hasMany('App\Models\Periodo', 'id', 'periodo_id');
    }






}
