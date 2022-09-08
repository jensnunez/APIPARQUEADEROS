<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'tipo_usuarios';

    protected $fillable = ['descripcion'];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
