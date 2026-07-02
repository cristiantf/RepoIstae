<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metadato extends Model
{
    protected $table = 'metadatos';

    protected $fillable = [
        'documento_id',
        'campo',
        'valor',
        'calificador',
    ];

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
}
