<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes biens immobiliers') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <!-- Bouton Ajouter -->
                <div class="flex justify-end mb-6">
                    <a href="{{ route('properties.create') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        + Ajouter un bien
                    </a>
                </div>

                <!-- Liste des biens -->
                @if($properties->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($properties as $property)
                            <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                                <!-- Image -->
                                @if($property->images->count())
                                    <img src="{{ asset('storage/' . $property->images->first()->image_path) }}" 
                                         class="w-full h-48 object-cover" 
                                         alt="Photo du bien">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">Pas de photo</span>
                                    </div>
                                @endif

                                <!-- Infos -->
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold">{{ $property->title }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ ucfirst($property->type) }} - {{ $property->city }} 
                                        {{ $property->district ? '('.$property->district.')' : '' }}
                                    </p>
                                    <p class="text-blue-600 font-bold mt-2">
                                        {{ number_format($property->price, 0, ',', ' ') }} FCFA
                                    </p>

                                    <!-- Boutons -->
                                    <div class="mt-4 flex justify-between">
                                        <a href="{{ route('properties.show', $property) }}" class="text-blue-600 hover:underline">Voir</a>
                                        <a href="{{ route('properties.edit', $property) }}" class="text-gray-600 hover:underline">Éditer</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">Vous n’avez encore publié aucun bien.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
