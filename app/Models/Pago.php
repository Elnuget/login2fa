<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula_id',
        'monto',
        'fecha_pago',
        'metodo_pago',
        'comprobante_pago',
        'totalmente_pagado',
        'valor_pendiente',
        'fecha_proximo_pago',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }
}