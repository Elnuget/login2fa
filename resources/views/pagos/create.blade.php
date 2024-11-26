<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Pago') }}
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
                <form action="{{ route('pagos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="matricula_id">{{ __('Matrícula') }}</label>
                        <select name="matricula_id" id="matricula_id" class="block mt-1 w-full">
                            @foreach ($matriculas as $matricula)
                                <option value="{{ $matricula->id }}">{{ $matricula->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="monto_pagado">{{ __('Monto Pagado') }}</label>
                        <input type="number" step="0.01" name="monto_pagado" id="monto_pagado" class="block mt-1 w-full" required>
                    </div>
                    <div>
                        <label for="fecha_pago">{{ __('Fecha de Pago') }}</label>
                        <input type="date" name="fecha_pago" id="fecha_pago" class="block mt-1 w-full" required>
                    </div>
                    <div>
                        <label for="metodo_pago">{{ __('Método de Pago') }}</label>
                        <select name="metodo_pago" id="metodo_pago" class="block mt-1 w-full">
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>
                    <div>
                        <label for="comprobante_pago">{{ __('Comprobante de Pago') }}</label>
                        <input type="file" name="comprobante_pago" id="comprobante_pago" class="block mt-1 w-full">
                    </div>
                    <div>
                        <label for="estado_pago">{{ __('Estado de Pago') }}</label>
                        <select name="estado_pago" id="estado_pago" class="block mt-1 w-full" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="verificado">Verificado</option>
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
</x-app-layout>