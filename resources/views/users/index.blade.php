<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('users.create') }}"
                        class="inline-flex items-center px-4 py-2 mb-4 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md">
                        <!-- Icono de "agregar" -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Agregar Usuario
                    </a>

                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                        <thead>
                            <tr
                                class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Nombre</th>
                                <th class="py-3 px-6 text-left">Email</th>
                                <th class="py-3 px-6 text-left">Rol</th>
                                <th class="py-3 px-6 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-gray-300 text-sm font-light">
                            @foreach ($users as $user)
                                <tr
                                    class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $user->email }}</td>
                                    <td class="py-3 px-6 text-left">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                    <td class="py-3 px-6 text-center flex justify-center">
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="flex items-center mr-2 text-blue-500 hover:text-blue-600">
                                            <!-- Icono de "editar" -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487a2.25 2.25 0 0 1 3.181 3.182l-12.62 12.62-4.03.86a.75.75 0 0 1-.883-.884l.86-4.03 12.62-12.62z" />
                                            </svg>
                                            Editar
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center text-red-500 hover:text-red-600">
                                                <!-- Icono de "eliminar" -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 9.75L4.5 9.75m15 0l-.628 10.098A2.25 2.25 0 0 1 16.628 22.5H7.372a2.25 2.25 0 0 1-2.244-2.652L4.5 9.75m15 0L15.75 4.5m-7.5 0L4.5 9.75m3.75-5.25h7.5m-7.5 0A2.25 2.25 0 0 1 8.25 4.5h7.5A2.25 2.25 0 0 1 18 6.75m-9.75-2.25L12 3" />
                                                </svg>
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>