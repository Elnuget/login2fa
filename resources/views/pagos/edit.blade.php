
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Pago') }}
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
                <form action="{{ route('pagos.update', $pago) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-label for="matricula_id" :value="__('Matrícula')" />
                        <select name="matricula_id" id="matricula_id" class="block mt-1 w-full">
                            @foreach ($matriculas as $matricula)
                                <option value="{{ $matricula->id }}" {{ $pago->matricula_id == $matricula->id ? 'selected' : '' }}>{{ $matricula->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-label for="monto_pagado" :value="__('Monto Pagado')" />
                        <input type="number" step="0.01" name="monto_pagado" id="monto_pagado" class="block mt-1 w-full" value="{{ $pago->monto_pagado }}" required>
                    </div>
                    <div>
                        <x-label for="fecha_pago" :value="__('Fecha de Pago')" />
                        <input type="date" name="fecha_pago" id="fecha_pago" class="block mt-1 w-full" value="{{ $pago->fecha_pago }}" required>
                    </div>
                    <div>
                        <x-label for="metodo_pago" :value="__('Método de Pago')" />
                        <select name="metodo_pago" id="metodo_pago" class="block mt-1 w-full">
                            <option value="efectivo" {{ $pago->metodo_pago == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="tarjeta" {{ $pago->metodo_pago == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                            <option value="transferencia" {{ $pago->metodo_pago == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                        </select>
                    </div>
                    <div>
                        <x-label for="comprobante_pago" :value="__('Comprobante de Pago')" />
                        <input type="file" name="comprobante_pago" id="comprobante_pago" class="block mt-1 w-full">
                        @if ($pago->comprobante_pago)
                            <a href="{{ asset('storage/' . $pago->comprobante_pago) }}" target="_blank">Ver Comprobante Actual</a>
                        @endif
                    </div>
                    <div>
                        <x-label for="estado_pago" :value="__('Estado de Pago')" />
                        <select name="estado_pago" id="estado_pago" class="block mt-1 w-full" required>
                            <option value="pendiente" {{ $pago->estado_pago == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="verificado" {{ $pago->estado_pago == 'verificado' ? 'selected' : '' }}>Verificado</option>
                            <option value="rechazado" {{ $pago->estado_pago == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
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
</x-app-layout>