<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Matricula') }}
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
                <form action="{{ route('matriculas.update', $matricula) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-label for="usuario_id" :value="__('Usuario')" />
                        <select name="usuario_id" id="usuario_id" class="block mt-1 w-full" {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ $matricula->usuario_id == $usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                        @if (!Auth::user()->hasRole('admin'))
                            <input type="hidden" name="usuario_id" value="{{ $matricula->usuario_id }}">
                        @endif
                    </div>
                    <div>
                        <x-label for="curso_id" :value="__('Curso')" />
                        <select name="curso_id" id="curso_id" class="block mt-1 w-full" onchange="setCoursePrice()">
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}" data-precio="{{ $curso->precio }}" {{ $matricula->curso_id == $curso->id ? 'selected' : '' }}>{{ $curso->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="monto" id="monto" value="{{ $matricula->curso->precio }}">
                    <div>
                        <x-label for="metodo_pago" :value="__('Método de Pago')" />
                        <select name="metodo_pago" id="metodo_pago" class="block mt-1 w-full">
                            <option value="efectivo" {{ $matricula->metodo_pago == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="tarjeta" {{ $matricula->metodo_pago == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                            <option value="transferencia" {{ $matricula->metodo_pago == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                        </select>
                    </div>
                    <div>
                        <x-label for="comprobante_pago" :value="__('Comprobante de Pago')" />
                        <input type="file" name="comprobante_pago" id="comprobante_pago" class="block mt-1 w-full">
                        @if ($matricula->comprobante_pago)
                            <a href="{{ asset('storage/' . $matricula->comprobante_pago) }}" target="_blank">Ver Comprobante Actual</a>
                        @endif
                    </div>
                    <div>
                        <x-label for="fecha_pago" :value="__('Fecha de Pago')" />
                        <input type="date" name="fecha_pago" id="fecha_pago" class="block mt-1 w-full" value="{{ $matricula->fecha_pago ?? \Carbon\Carbon::now('America/Guayaquil')->format('Y-m-d') }}" required onchange="setNextPaymentDate()">
                    </div>
                    <div>
                        <x-label for="totalmente_pagado" :value="__('Totalmente Pagado')" />
                        <input type="checkbox" name="totalmente_pagado" id="totalmente_pagado" class="block mt-1" value="1" {{ $matricula->totalmente_pagado ? 'checked' : '' }} onchange="togglePendingFields()">
                    </div>
                    <div id="anticipo_div">
                        <x-label for="anticipo" :value="__('Anticipo')" />
                        <input type="number" step="0.01" name="anticipo" id="anticipo" class="block mt-1 w-full" value="{{ $matricula->anticipo }}" oninput="calculatePendingAmount()">
                    </div>
                    <div id="valor_pendiente_div">
                        <x-label for="valor_pendiente" :value="__('Valor Pendiente')" />
                        <input type="number" step="0.01" name="valor_pendiente" id="valor_pendiente" class="block mt-1 w-full" value="{{ $matricula->valor_pendiente }}" readonly>
                    </div>
                    <div id="fecha_proximo_pago_div">
                        <x-label for="fecha_proximo_pago" :value="__('Fecha del Próximo Pago')" />
                        <input type="date" name="fecha_proximo_pago" id="fecha_proximo_pago" class="block mt-1 w-full" value="{{ $matricula->fecha_proximo_pago ?? \Carbon\Carbon::now('America/Guayaquil')->addDays(30)->format('Y-m-d') }}">
                    </div>
                    <div>
                        <x-label for="estado_matricula" :value="__('Estado de la Matrícula')" />
                        <select name="estado_matricula" id="estado_matricula" class="block mt-1 w-full" required>
                            <option value="pendiente" {{ $matricula->estado_matricula == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aprobado" {{ $matricula->estado_matricula == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                            <option value="rechazado" {{ $matricula->estado_matricula == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 dark:focus:ring-blue-800 active:bg-blue-700 transition ease-in-out duration-150">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function setCoursePrice() {
            var cursoSelect = document.getElementById('curso_id');
            var selectedOption = cursoSelect.options[cursoSelect.selectedIndex];
            var precio = selectedOption.getAttribute('data-precio');
            document.getElementById('monto').value = precio;
            calculatePendingAmount(precio);
        }
        function calculatePendingAmount(precioCurso) {
            var anticipo = parseFloat(document.getElementById('anticipo').value) || 0;
            var valorPendiente = precioCurso - anticipo;
            document.getElementById('valor_pendiente').value = valorPendiente.toFixed(2);
        }
        function togglePendingFields() {
            var totalmentePagado = document.getElementById('totalmente_pagado').checked;
            var anticipoDiv = document.getElementById('anticipo_div');
            var valorPendienteDiv = document.getElementById('valor_pendiente_div');
            var fechaProximoPagoDiv = document.getElementById('fecha_proximo_pago_div');
            if (totalmentePagado) {
                anticipoDiv.style.display = 'none';
                valorPendienteDiv.style.display = 'none';
                fechaProximoPagoDiv.style.display = 'none';
                document.getElementById('valor_pendiente').value = '';
                document.getElementById('fecha_proximo_pago').value = '';
            } else {
                anticipoDiv.style.display = 'block';
                valorPendienteDiv.style.display = 'block';
                fechaProximoPagoDiv.style.display = 'block';
            }
        }
        function setNextPaymentDate() {
            var fechaPago = document.getElementById('fecha_pago').value;
            var nextPaymentDate = new Date(fechaPago);
            nextPaymentDate.setDate(nextPaymentDate.getDate() + 30);
            document.getElementById('fecha_proximo_pago').value = nextPaymentDate.toISOString().split('T')[0];
        }
        document.addEventListener('DOMContentLoaded', function() {
            setCoursePrice();
            togglePendingFields();
            setNextPaymentDate();
        });
    </script>
</x-app-layout>