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
                        <select name="curso_id" id="curso_id" class="block mt-1 w-full" onchange="setCoursePrice()">
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}" data-precio="{{ $curso->precio }}">{{ $curso->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="monto" id="monto" value="">
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
                        <label for="fecha_pago" class="block font-medium text-sm text-gray-700">Fecha de Pago</label>
                        <input type="date" name="fecha_pago" id="fecha_pago" class="block mt-1 w-full" value="{{ \Carbon\Carbon::now('America/Guayaquil')->format('Y-m-d') }}" required onchange="setNextPaymentDate()">
                    </div>
                    <div>
                        <label for="totalmente_pagado" class="block font-medium text-sm text-gray-700">Totalmente Pagado</label>
                        <input type="checkbox" name="totalmente_pagado" id="totalmente_pagado" class="block mt-1" value="1" onchange="togglePendingFields()">
                    </div>
                    <div id="anticipo_div">
                        <label for="anticipo" class="block font-medium text-sm text-gray-700">Anticipo</label>
                        <input type="number" step="0.01" name="anticipo" id="anticipo" class="block mt-1 w-full" oninput="calculatePendingAmount()">
                    </div>
                    <div id="valor_pendiente_div">
                        <label for="valor_pendiente" class="block font-medium text-sm text-gray-700">Valor Pendiente</label>
                        <input type="number" step="0.01" name="valor_pendiente" id="valor_pendiente" class="block mt-1 w-full" readonly>
                    </div>
                    <div id="fecha_proximo_pago_div">
                        <label for="fecha_proximo_pago" class="block font-medium text-sm text-gray-700">Fecha del Próximo Pago</label>
                        <input type="date" name="fecha_proximo_pago" id="fecha_proximo_pago" class="block mt-1 w-full">
                    </div>
                    <div>
                        <label for="estado_matricula" class="block font-medium text-sm text-gray-700">Estado de la Matrícula</label>
                        <input type="text" name="estado_matricula" id="estado_matricula" class="block mt-1 w-full" value="pendiente" readonly>
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
            toggleComprobantePago();
            setCoursePrice();
            togglePendingFields();
            setNextPaymentDate();
        });
    </script>
</x-app-layout>