<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Rol') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nombre del Rol -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Rol</label>
                        <input type="text" name="name" id="name" value="{{ $role->name }}" required 
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 focus:border-blue-500 dark:bg-gray-900 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>

                    <!-- Permisos -->
                    <div class="mt-4">
                        <label for="permissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permisos</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2">
                            @foreach ($permissions as $permission)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                           class="form-checkbox h-5 w-5 text-blue-600 transition duration-150 ease-in-out dark:bg-gray-700 dark:border-gray-600" 
                                           {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botón Actualizar -->
                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <!-- Icono de Actualizar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a5 5 0 0 1 5 5h1.71l-2.58 2.59a1 1 0 0 0 0 1.41l2.58 2.59H15a5 5 0 0 1-5 5 5 5 0 0 1-5-5H3l2.58-2.59a1 1 0 0 0 0-1.41L3 8h2A5 5 0 0 1 10 5z" clip-rule="evenodd" />
                            </svg>
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
