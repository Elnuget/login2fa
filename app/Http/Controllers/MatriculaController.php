<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\User;
use App\Models\Curso;
use App\Models\Pago;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $matriculas = Matricula::with('usuario', 'curso')->get();
        } else {
            $matriculas = Matricula::with('usuario', 'curso')->where('usuario_id', auth()->id())->get();
        }
        return view('matriculas.index', compact('matriculas'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole('admin')) {
            $usuarios = User::where('id', auth()->id())->get();
        } else {
            $usuarios = User::all();
        }
        $cursos = Curso::where('estado', 'activo')->get(); // Filter active courses
        return view('matriculas.create', compact('usuarios', 'cursos'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('admin') && $request->usuario_id != auth()->id()) {
            return redirect()->route('matriculas.index')->withErrors(['error' => 'No puedes crear matrículas para otros usuarios.']);
        }

        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'curso_id' => 'required|exists:cursos,id',
            'metodo_pago' => 'required|string',
            'comprobante_pago' => 'nullable|file',
            'fecha_pago' => 'required|date',
            'totalmente_pagado' => 'boolean',
            'anticipo' => 'nullable|numeric',
            'valor_pendiente' => 'nullable|numeric',
            'fecha_proximo_pago' => 'nullable|date',
            'estado_matricula' => 'nullable|in:pendiente,aprobado,rechazado',
            'monto' => 'required|numeric|min:0',
        ]);

        // Check for existing enrollment
        $existingMatricula = Matricula::where('usuario_id', $request->usuario_id)
                                      ->where('curso_id', $request->curso_id)
                                      ->first();
        if ($existingMatricula) {
            return redirect()->back()->withErrors(['error' => 'El usuario ya está matriculado en este curso.']);
        }

        $curso = Curso::find($request->curso_id);
        $matricula = new Matricula([
            'usuario_id' => $request->usuario_id,
            'curso_id' => $request->curso_id,
            'monto_total' => $curso->precio,
            'estado_matricula' => 'pendiente', // Set default state to 'pendiente'
        ]);
        $matricula->save();

        $pago = new Pago([
            'matricula_id' => $matricula->id,
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'metodo_pago' => $request->metodo_pago,
            'comprobante_pago' => $request->hasFile('comprobante_pago') ? $request->file('comprobante_pago')->store('comprobantes') : null,
            'totalmente_pagado' => $request->totalmente_pagado ?? false,
            'valor_pendiente' => $curso->precio - ($request->anticipo ?? 0),
            'fecha_proximo_pago' => $request->fecha_proximo_pago,
        ]);
        $pago->save();

        $matricula->updateEstadoMatricula();

        return redirect()->route('matriculas.index');
    }

    public function show(Matricula $matricula)
    {
        if (!auth()->user()->hasRole('admin') && $matricula->usuario_id != auth()->id()) {
            return redirect()->route('matriculas.index')->withErrors(['error' => 'No tienes permiso para ver esta matrícula.']);
        }
        return view('matriculas.show', compact('matricula'));
    }

    public function edit(Matricula $matricula)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('matriculas.index')->withErrors(['error' => 'No tienes permiso para editar esta matrícula.']);
        }
        $usuarios = User::all();
        $cursos = Curso::where('estado', 'activo')->get(); // Filter active courses
        return view('matriculas.edit', compact('matricula', 'usuarios', 'cursos'));
    }

    public function update(Request $request, Matricula $matricula)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('matriculas.index')->withErrors(['error' => 'No tienes permiso para actualizar esta matrícula.']);
        }

        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'curso_id' => 'required|exists:cursos,id',
            'metodo_pago' => 'required|string',
            'comprobante_pago' => 'nullable|file|required_if:metodo_pago,!=,efectivo',
            'fecha_pago' => 'required|date',
            'totalmente_pagado' => 'boolean',
            'anticipo' => 'nullable|numeric',
            'valor_pendiente' => 'nullable|numeric',
            'fecha_proximo_pago' => 'nullable|date',
            'estado_matricula' => 'nullable|in:pendiente,aprobado,rechazado',
            'monto' => 'required|numeric|min:0',
        ]);

        // Check for existing enrollment
        $existingMatricula = Matricula::where('usuario_id', $request->usuario_id)
                                      ->where('curso_id', $request->curso_id)
                                      ->where('id', '!=', $matricula->id)
                                      ->first();
        if ($existingMatricula) {
            return redirect()->back()->withErrors(['error' => 'El usuario ya está matriculado en este curso.']);
        }

        $curso = Curso::find($request->curso_id);
        $matricula->fill([
            'usuario_id' => $request->usuario_id,
            'curso_id' => $request->curso_id,
            'estado_matricula' => $request->estado_matricula,
        ]);
        $matricula->save();

        $pago = new Pago([
            'matricula_id' => $matricula->id,
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'metodo_pago' => $request->metodo_pago,
            'comprobante_pago' => $request->hasFile('comprobante_pago') ? $request->file('comprobante_pago')->store('comprobantes') : null,
            'totalmente_pagado' => $request->totalmente_pagado ?? false,
            'valor_pendiente' => $curso->precio - ($request->anticipo ?? 0),
            'fecha_proximo_pago' => $request->fecha_proximo_pago,
        ]);
        $pago->save();

        $matricula->updateEstadoMatricula();

        return redirect()->route('matriculas.index');
    }

    public function destroy(Matricula $matricula)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('matriculas.index')->withErrors(['error' => 'No tienes permiso para eliminar esta matrícula.']);
        }
        $matricula->delete();
        return redirect()->route('matriculas.index');
    }
}
