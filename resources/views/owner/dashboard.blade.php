<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Propriétaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <p>Bienvenue {{ Auth::user()->name }} 👋</p>
                <p class="mt-2">Ici tu pourras gérer tes annonces immobilières.</p>
            </div>
        </div>
    </div>
</x-app-layout>

