<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Matricula') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('matriculas.update', $matricula) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-label for="usuario_id" :value="__('Usuario')" />
                        <select name="usuario_id" id="usuario_id" class="block mt-1 w-full">
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ $matricula->usuario_id == $usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-label for="curso_id" :value="__('Curso')" />
                        <select name="curso_id" id="curso_id" class="block mt-1 w-full">
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ $matricula->curso_id == $curso->id ? 'selected' : '' }}>{{ $curso->name }}</option>
                            @endforeach
                        </select>
                    </div>
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