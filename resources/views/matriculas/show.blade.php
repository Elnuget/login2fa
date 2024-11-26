<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de la Matricula') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div>
                        <x-label :value="__('Usuario')" />
                        <p>{{ $matricula->usuario->name }}</p>
                    </div>
                    <div>
                        <x-label :value="__('Curso')" />
                        <p>{{ $matricula->curso->name }}</p>
                    </div>
                    <div>
                        <x-label :value="__('Monto Total')" />
                        <p>{{ $matricula->monto_total }}</p>
                    </div>
                    <div>
                        <x-label :value="__('Monto Pagado')" />
                        <p>{{ $matricula->monto_pagado }}</p>
                    </div>
                    <div>
                        <x-label :value="__('Monto Pendiente')" />
                        <p>{{ $matricula->monto_pendiente }}</p>
                    </div>
                    <div>
                        <x-label :value="__('Estado de la Matrícula')" />
                        <p>{{ $matricula->estado_matricula }}</p>
                    </div>
                    <div>
                        <a href="{{ route('pagos.index', ['matricula_id' => $matricula->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ver Detalle de Pagos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>