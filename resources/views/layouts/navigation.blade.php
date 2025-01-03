<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Dashboard Link -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <!-- Escritorio Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h16v2H4zM4 20h16v-2H4zM9 8h6v8H9z"/>
                        </svg>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Matriculas Link -->
                    <x-nav-link :href="route('matriculas.index')" :active="request()->routeIs('matriculas.*')">
                        <!-- Book Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6 4v16c0 .55.45 1 1 1h10c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H7c-.55 0-1 .45-1 1zm3 0h6v5H9V4zm0 7h6v5H9v-5z"/>
                        </svg>
                        {{ __('Matriculas') }}
                    </x-nav-link>

                    <!-- Pagos Link -->
                    <x-nav-link :href="route('pagos.index')" :active="request()->routeIs('pagos.*')">
                        <!-- Money Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 4C7.03 4 3 8.03 3 13s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 16c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                        </svg>
                        {{ __('Pagos') }}
                    </x-nav-link>

                    @if (Auth::user()->hasRole('admin')) <!-- Verifica si el usuario tiene el rol de administrador -->
                        <!-- Gestión de Usuarios Link with Group Icon -->
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            <!-- Grupo Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 11c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm-8 0c1.1 0 2-.9 2-2S9.1 7 8 7s-2 .9-2 2 .9 2 2 2zm4 2c2.67 0 8 1.34 8 4v2H4v-2c0-2.66 5.33-4 8-4z"/>
                            </svg>
                            {{ __('Gestión de Usuarios') }}
                        </x-nav-link>
                        <x-nav-link :href="route('cursos.index')" :active="request()->routeIs('cursos.*')">
                            <!-- Book Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6 4v16c0 .55.45 1 1 1h10c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H7c-.55 0-1 .45-1 1zm3 0h6v5H9V4zm0 7h6v5H9v-5z"/>
                            </svg>
                            {{ __('Cursos') }}
                        </x-nav-link>

                        <!-- Gestión de Roles Link with Person Icon -->
                        <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                            <!-- Persona Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            {{ __('Gestión de Roles') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Responsive Matriculas Link -->
            <x-responsive-nav-link :href="route('matriculas.index')" :active="request()->routeIs('matriculas.*')">
                {{ __('Matriculas') }}
            </x-responsive-nav-link>

            <!-- Responsive Pagos Link -->
            <x-responsive-nav-link :href="route('pagos.index')" :active="request()->routeIs('pagos.*')">
                {{ __('Pagos') }}
            </x-responsive-nav-link>

            @if (Auth::user()->hasRole('admin'))
                <!-- Responsive Gestión de Usuarios Link with Group Icon -->
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('Gestión de Usuarios') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('cursos.index')" :active="request()->routeIs('cursos.*')">
                    {{ __('Cursos') }}
                </x-responsive-nav-link>

                <!-- Responsive Gestión de Roles Link with Person Icon -->
                <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                    {{ __('Gestión de Roles') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
