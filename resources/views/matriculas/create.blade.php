<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Matricula') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if ($errors->any())
                    <div class="mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-500">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('matriculas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="usuario_id" class="block font-medium text-sm text-gray-700">Usuario</label>
                        <select name="usuario_id" id="usuario_id" class="block mt-1 w-full" {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ Auth::user()->id == $usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                        @if (!Auth::user()->hasRole('admin'))
                            <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        @endif
                    </div>
                    <div>
                        <label for="curso_id" class="block font-medium text-sm text-gray-700">Curso</label>
                        <select name="curso_id" id="curso_id" class="block mt-1 w-full">
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="metodo_pago" class="block font-medium text-sm text-gray-700">Método de Pago</label>
                        <select name="metodo_pago" id="metodo_pago" class="block mt-1 w-full" onchange="toggleComprobantePago()">
                            <option value="efectivo">Efectivo</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>
                    <div id="comprobante_pago_div">
                        <label for="comprobante_pago" class="block font-medium text-sm text-gray-700">Comprobante de Pago</label>
                        <input type="file" name="comprobante_pago" id="comprobante_pago" class="block mt-1 w-full">
                    </div>
                    <div>
                        <label for="precio_curso" class="block font-medium text-sm text-gray-700">Precio del Curso</label>
                        <input type="number" step="0.01" name="precio_curso" id="precio_curso" class="block mt-1 w-full" required>
                    </div>
                    <div>
                        <label for="fecha_pago" class="block font-medium text-sm text-gray-700">Fecha de Pago</label>
                        <input type="date" name="fecha_pago" id="fecha_pago" class="block mt-1 w-full" required>
                    </div>
                    <div>
                        <label for="totalmente_pagado" class="block font-medium text-sm text-gray-700">Totalmente Pagado</label>
                        <input type="checkbox" name="totalmente_pagado" id="totalmente_pagado" class="block mt-1" value="1">
                    </div>
                    <div>
                        <label for="valor_pendiente" class="block font-medium text-sm text-gray-700">Valor Pendiente</label>
                        <input type="number" step="0.01" name="valor_pendiente" id="valor_pendiente" class="block mt-1 w-full">
                    </div>
                    <div>
                        <label for="fecha_proximo_pago" class="block font-medium text-sm text-gray-700">Fecha del Próximo Pago</label>
                        <input type="date" name="fecha_proximo_pago" id="fecha_proximo_pago" class="block mt-1 w-full">
                    </div>
                    <div>
                        <label for="estado_matricula" class="block font-medium text-sm text-gray-700">Estado de la Matrícula</label>
                        <select name="estado_matricula" id="estado_matricula" class="block mt-1 w-full" required>
                            <option value="aprobado">Aprobado</option>
                            <option value="rechazado">Rechazado</option>
                        </select>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 dark:focus:ring-blue-800 active:bg-blue-700 transition ease-in-out duration-150">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function toggleComprobantePago() {
            var metodoPago = document.getElementById('metodo_pago').value;
            var comprobantePagoDiv = document.getElementById('comprobante_pago_div');
            if (metodoPago === 'efectivo') {
                comprobantePagoDiv.style.display = 'none';
                document.getElementById('comprobante_pago').value = '';
            } else {
                comprobantePagoDiv.style.display = 'block';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            toggleComprobantePago();
        });
    </script>
</x-app-layout>