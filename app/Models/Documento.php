<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'coleccion_id',
        'user_id',
        'titulo',
        'resumen',
        'palabras_clave',
        'autor',
        'coautores',
        'director_tesis',
        'institucion',
        'carrera',
        'tipo_documento',
        'fecha_publicacion',
        'anno',
        'idioma',
        'derechos',
        'archivo_nombre',
        'archivo_url',
        'archivo_tamano',
        'estado',
        'vistas',
        'descargas',
        'isbn_issn',
        'doi',
        'url_externa',
    ];

    public function coleccion()
    {
        return $this->belongsTo(Coleccion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function metadatos()
    {
        return $this->hasMany(Metadato::class);
    }

    public function workflowHistorial()
    {
        return $this->hasMany(WorkflowHistorial::class);
    }

    public function estadisticas()
    {
        return $this->hasMany(Estadistica::class);
    }
}
