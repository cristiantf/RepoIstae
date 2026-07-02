<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coleccion extends Model
{
    protected $table = 'colecciones';

    protected $fillable = [
        'comunidad_id',
        'nombre',
        'descripcion',
        'slug',
        'activo',
        'orden',
    ];

    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }
}
