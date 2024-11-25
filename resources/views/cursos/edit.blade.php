<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Curso') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Mostrar errores de validación -->
                @if ($errors->any())
                    <div class="text-red-500 bg-red-100 border border-red-300 p-4 rounded-md mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulario -->
                <form action="{{ route('cursos.update', $curso->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nombre del Curso
                        </label>
                        <input type="text" name="nombre" id="nombre" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:border-blue-300 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600" value="{{ old('nombre', $curso->nombre) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Descripción
                        </label>
                        <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:border-blue-300 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600">{{ old('descripcion', $curso->descripcion) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Precio
                        </label>
                        <input type="number" name="precio" id="precio" step="0.01" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:border-blue-300 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600" value="{{ old('precio', $curso->precio) }}" required>
                    </div>

                    

                    <div class="mb-4">
                        <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Estado
                        </label>
                        <select name="estado" id="estado" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:border-blue-300 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600">
                            <option value="activo" {{ old('estado', $curso->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado', $curso->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-500">
                            Actualizar Curso
                        </button>
                        <a href="{{ route('cursos.index') }}" class="ml-2 bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-500">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
