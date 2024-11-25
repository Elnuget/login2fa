<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Matricula') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('matriculas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="usuario_id" class="block font-medium text-sm text-gray-700">Usuario</label>
                        <select name="usuario_id" id="usuario_id" class="block mt-1 w-full">
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>
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