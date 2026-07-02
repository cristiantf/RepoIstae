<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowHistorial extends Model
{
    protected $table = 'workflow_historial';

    protected $fillable = [
        'documento_id',
        'user_id',
        'estado_anterior',
        'estado_nuevo',
        'comentario',
    ];

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
