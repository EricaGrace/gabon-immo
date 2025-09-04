<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord Propriétaire') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Gérer mes annonces</h3>
                        <p class="text-sm text-gray-600 mt-1">Crée, modifie et publie tes biens.</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('properties.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">
                            {{ __('Mes biens') }}
                        </a>
                        <a href="{{ route('properties.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">
                            {{ __('Publier un bien') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
