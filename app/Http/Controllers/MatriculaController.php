<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\User;
use App\Models\Curso;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::all();
        return view('matriculas.index', compact('matriculas'));
    }

    public function create()
    {
        $usuarios = User::all();
        $cursos = Curso::all();
        return view('matriculas.create', compact('usuarios', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'curso_id' => 'required|exists:cursos,id',
            'metodo_pago' => 'required|string',
            'comprobante_pago' => 'nullable|file',
        ]);

        $matricula = new Matricula($request->all());
        if ($request->metodo_pago !== 'efectivo' && $request->hasFile('comprobante_pago')) {
            $matricula->comprobante_pago = $request->file('comprobante_pago')->store('comprobantes');
        } else {
            $matricula->comprobante_pago = null;
        }
        $matricula->save();

        return redirect()->route('matriculas.index');
    }

    public function show(Matricula $matricula)
    {
        return view('matriculas.show', compact('matricula'));
    }

    public function edit(Matricula $matricula)
    {
        return view('matriculas.edit', compact('matricula'));
    }

    public function update(Request $request, Matricula $matricula)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'curso_id' => 'required|exists:cursos,id',
            'metodo_pago' => 'required|string',
            'comprobante_pago' => 'nullable|file|required_if:metodo_pago,!=,efectivo',
        ]);

        $matricula->fill($request->all());
        if ($request->hasFile('comprobante_pago')) {
            $matricula->comprobante_pago = $request->file('comprobante_pago')->store('comprobantes');
        }
        $matricula->save();

        return redirect()->route('matriculas.index');
    }

    public function destroy(Matricula $matricula)
    {
        $matricula->delete();
        return redirect()->route('matriculas.index');
    }
}
