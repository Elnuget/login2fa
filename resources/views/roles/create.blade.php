<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Rol') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <!-- Nombre del Rol -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Rol</label>
                        <input type="text" name="name" id="name" required 
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 focus:border-blue-500 dark:bg-gray-900 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    
                    <!-- Permisos -->
                    <div class="mt-4">
                        <label for="permissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permisos</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2">
                            @foreach ($permissions as $permission)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                           class="form-checkbox h-5 w-5 text-blue-600 transition duration-150 ease-in-out dark:bg-gray-700 dark:border-gray-600">
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botón Guardar -->
                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <!-- Icono de Guardar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17 16V8H3v8h14zm0-10V4a1 1 0 0 0-1-1h-2V2a1 1 0 1 0-2 0v1H8V2a1 1 0 1 0-2 0v1H4a1 1 0 0 0-1 1v2h14zm-4 5H7a1 1 0 1 1 0-2h6a1 1 0 1 1 0 2z" />
                            </svg>
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
