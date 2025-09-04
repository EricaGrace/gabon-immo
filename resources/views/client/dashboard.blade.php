<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <p>Bienvenue {{ Auth::user()->name }} 👋</p>
                <p class="mt-2">Commence ta recherche de logement dès maintenant.</p>
            </div>
        </div>
    </div>
</x-app-layout>
