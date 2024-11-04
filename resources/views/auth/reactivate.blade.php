<!-- resources/views/auth/reactivate.blade.php -->
<x-guest-layout>
    <h2 class="text-lg font-bold">Reactivar Cuenta</h2>

    @if (session('status'))
        <div class="mb-4 text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('account.reactivate') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="mt-4">
            {{ __('Reactivar Cuenta') }}
        </x-primary-button>
    </form>
</x-guest-layout>
