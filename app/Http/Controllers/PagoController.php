<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Matricula;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with('matricula')->get();
        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        $matriculas = Matricula::all();
        return view('pagos.create', compact('matriculas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricula_id' => 'required|exists:matriculas,id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'required|string',
            'comprobante_pago' => 'nullable|file',
            'totalmente_pagado' => 'boolean',
            'valor_pendiente' => 'nullable|numeric',
            'fecha_proximo_pago' => 'nullable|date',
        ]);

        $pago = new Pago([
            'matricula_id' => $request->matricula_id,
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'metodo_pago' => $request->metodo_pago,
            'comprobante_pago' => $request->hasFile('comprobante_pago') ? $request->file('comprobante_pago')->store('comprobantes') : null,
            'totalmente_pagado' => $request->totalmente_pagado ?? false,
            'valor_pendiente' => $request->valor_pendiente,
            'fecha_proximo_pago' => $request->fecha_proximo_pago,
        ]);
        $pago->save();

        $pago->matricula->updateEstadoMatricula();

        return redirect()->route('pagos.index');
    }

    public function show(Pago $pago)
    {
        return view('pagos.show', compact('pago'));
    }

    public function edit(Pago $pago)
    {
        $matriculas = Matricula::all();
        return view('pagos.edit', compact('pago', 'matriculas'));
    }

    public function update(Request $request, Pago $pago)
    {
        $request->validate([
            'matricula_id' => 'required|exists:matriculas,id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'required|string',
            'comprobante_pago' => 'nullable|file',
            'totalmente_pagado' => 'boolean',
            'valor_pendiente' => 'nullable|numeric',
            'fecha_proximo_pago' => 'nullable|date',
        ]);

        $pago->fill([
            'matricula_id' => $request->matricula_id,
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'metodo_pago' => $request->metodo_pago,
            'comprobante_pago' => $request->hasFile('comprobante_pago') ? $request->file('comprobante_pago')->store('comprobantes') : null,
            'totalmente_pagado' => $request->totalmente_pagado ?? false,
            'valor_pendiente' => $request->valor_pendiente,
            'fecha_proximo_pago' => $request->fecha_proximo_pago,
        ]);
        $pago->save();

        $pago->matricula->updateEstadoMatricula();

        return redirect()->route('pagos.index');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index');
    }

    public function verify(Pago $pago)
    {
        $pago->estado_pago = 'verificado';
        $pago->save();

        $pago->matricula->updateEstadoMatricula();

        return redirect()->route('pagos.index');
    }

    public function reject(Pago $pago)
    {
        $pago->estado_pago = 'rechazado';
        $pago->save();

        return redirect()->route('pagos.index');
    }
}