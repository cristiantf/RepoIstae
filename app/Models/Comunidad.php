<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    protected $table = 'comunidades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'logo_path',
        'slug',
        'activo',
        'orden',
    ];

    public function colecciones()
    {
        return $this->hasMany(Coleccion::class);
    }
}
