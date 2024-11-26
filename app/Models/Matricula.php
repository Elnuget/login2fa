<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'curso_id',
        'monto_total',
        'estado_matricula',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function getMontoPagadoAttribute()
    {
        return $this->pagos()->where('estado_pago', 'verificado')->sum('monto_pagado');
    }

    public function getMontoPendienteAttribute()
    {
        return $this->monto_total - $this->monto_pagado;
    }

    public function updateEstadoMatricula()
    {
        if ($this->monto_pagado >= $this->monto_total) {
            $this->estado_matricula = 'completada';
            $this->save();
        }
    }
}
