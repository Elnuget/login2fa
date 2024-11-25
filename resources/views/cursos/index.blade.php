<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Cursos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Mostrar mensaje de éxito si existe -->
                @if (session('success'))
                    <div class="text-green-500 bg-green-100 border border-green-300 p-4 rounded-md mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Botón para crear un nuevo curso -->
                <a href="{{ route('cursos.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Crear Nuevo Curso
                </a>

                <!-- Tabla de cursos -->
                <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg">
                    <thead>
                        <tr class="w-full bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-200 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Nombre</th>
                            <th class="py-3 px-6 text-left">Descripción</th>
                            <th class="py-3 px-6 text-center">Precio</th>
                            
                            <th class="py-3 px-6 text-center">Estado</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-200 text-sm font-light">
                        @forelse ($cursos as $curso)
                            <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <td class="py-3 px-6 text-left">{{ $curso->nombre }}</td>
                                <td class="py-3 px-6 text-left">{{ $curso->descripcion }}</td>
                                <td class="py-3 px-6 text-center">${{ number_format($curso->precio, 2) }}</td>
                                
                                <td class="py-3 px-6 text-center">
                                    <span class="px-2 py-1 font-semibold leading-tight {{ $curso->estado === 'activo' ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }} rounded-full">
                                        {{ ucfirst($curso->estado) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center flex items-center justify-center space-x-2">
                                    <!-- Botón de Editar -->
                                    <a href="{{ route('cursos.edit', $curso->id) }}" class="text-blue-500 hover:text-blue-700 transition duration-150 ease-in-out inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232a2 2 0 0 1 2.828 0l1.768 1.768a2 2 0 0 1 0 2.828l-8.486 8.486a4 4 0 0 1-1.414.878l-4 1a1 1 0 0 1-1.252-1.252l1-4a4 4 0 0 1 .878-1.414l8.486-8.486z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <!-- Botón de Eliminar -->
                                    <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition duration-150 ease-in-out inline-flex items-center" onclick="return confirm('¿Estás seguro de que deseas eliminar este curso?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-6 text-center text-gray-500 dark:text-gray-400">
                                    No hay cursos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
