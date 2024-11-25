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
                        <x-label :value="__('Método de Pago')" />
                        <p>{{ $matricula->metodo_pago }}</p>
                    </div>
                    <div>
                        <x-label :value="__('Comprobante de Pago')" />
                        @if ($matricula->comprobante_pago)
                            <a href="{{ asset('storage/' . $matricula->comprobante_pago) }}" target="_blank">Ver Comprobante</a>
                        @else
                            <p>N/A</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>