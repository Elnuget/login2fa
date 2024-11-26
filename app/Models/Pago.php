<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula_id',
        'monto_pagado',
        'fecha_pago',
        'metodo_pago',
        'comprobante_pago',
        'estado_pago',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }
}