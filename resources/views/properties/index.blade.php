<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes biens immobiliers') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <!-- Barre de recherche + bouton Ajouter -->
                <div class="flex justify-between items-center mb-6">
                    <form method="GET" class="flex gap-3">
                        <x-input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher (titre, ville, type)" />
                        <select name="status" class="border-gray-300 rounded-md">
                            <option value="">Tous statuts</option>
                            <option value="draft"     {{ request('status')==='draft'     ? 'selected' : '' }}>Brouillon</option>
                            <option value="published" {{ request('status')==='published' ? 'selected' : '' }}>Publiée</option>
                            <option value="archived"  {{ request('status')==='archived'  ? 'selected' : '' }}>Archivée</option>
                        </select>
                        <x-button>Filtrer</x-button>
                    </form>

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
                                <!-- Image cover (ou première) -->
                                @php
                                    $cover = $property->images->firstWhere('is_cover', true) ?? $property->images->first();
                                @endphp
                                @if($cover)
                                    <img src="{{ asset('storage/' . $cover->image_path) }}"
                                         class="w-full h-48 object-cover"
                                         alt="Photo du bien">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">Pas de photo</span>
                                    </div>
                                @endif

                                <!-- Infos -->
                                <div class="p-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold">{{ $property->title }}</h3>

                                        <!-- Badge statut (sans @php, juste des ternaires) -->
                                        <span class="text-xs px-2 py-1 rounded
                                            {{ $property->status==='published'
                                                ? 'bg-green-100 text-green-700'
                                                : ($property->status==='archived'
                                                    ? 'bg-yellow-100 text-yellow-700'
                                                    : 'bg-gray-100 text-gray-700') }}">
                                            {{ $property->status==='published'
                                                ? 'Publiée'
                                                : ($property->status==='archived' ? 'Archivée' : 'Brouillon') }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ ucfirst($property->type) }} — {{ $property->city }}
                                        {{ $property->district ? '('.$property->district.')' : '' }}
                                    </p>
                                    <p class="text-blue-600 font-bold mt-2">
                                        {{ number_format($property->price, 0, ',', ' ') }} FCFA
                                    </p>

                                    <!-- Lien voir / éditer -->
                                    <div class="mt-4 flex justify-between items-center">
                                        <div class="flex gap-4">
                                            <a href="{{ route('properties.show', $property) }}" class="text-blue-600 hover:underline">Voir</a>
                                            <a href="{{ route('properties.edit', $property) }}" class="text-gray-700 hover:underline">Éditer</a>
                                        </div>
                                    </div>

                                    <!-- Actions statut -->
                                  
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $properties->links() }}
                    </div>
                @else
                    <p class="text-gray-600">Vous n’avez encore publié aucun bien.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
