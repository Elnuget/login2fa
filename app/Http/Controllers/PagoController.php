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
            'monto_pagado' => 'required|numeric',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'required|string',
            'comprobante_pago' => 'nullable|file',
            'estado_pago' => 'required|in:pendiente,verificado,rechazado',
        ]);

        $pago = new Pago($request->all());
        if ($request->hasFile('comprobante_pago')) {
            $pago->comprobante_pago = $request->file('comprobante_pago')->store('comprobantes');
        }
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
            'monto_pagado' => 'required|numeric',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'required|string',
            'comprobante_pago' => 'nullable|file',
            'estado_pago' => 'required|in:pendiente,verificado,rechazado',
        ]);

        $pago->fill($request->all());
        if ($request->hasFile('comprobante_pago')) {
            $pago->comprobante_pago = $request->file('comprobante_pago')->store('comprobantes');
        }
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