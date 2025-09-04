<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier un bien immobilier') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                        <ul class="list-disc ml-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('properties.update', $property) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Titre -->
                    <div>
                        <x-label for="title" value="Titre de l’annonce" />
                        <x-input id="title" type="text" name="title" class="block w-full mt-1"
                                 value="{{ old('title', $property->title) }}" required />
                    </div>

                    <!-- Type -->
                    <div>
                        <x-label for="type" value="Type de bien" />
                        <select id="type" name="type" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                            <option value="studio" {{ $property->type == 'studio' ? 'selected' : '' }}>Studio</option>
                            <option value="appartement" {{ $property->type == 'appartement' ? 'selected' : '' }}>Appartement</option>
                            <option value="maison" {{ $property->type == 'maison' ? 'selected' : '' }}>Maison</option>
                            <option value="terrain" {{ $property->type == 'terrain' ? 'selected' : '' }}>Terrain</option>
                        </select>
                    </div>

                    <!-- Ville -->
                    <div>
                        <x-label for="city" value="Ville" />
                        <x-input id="city" type="text" name="city" class="block w-full mt-1"
                                 value="{{ old('city', $property->city) }}" required />
                    </div>

                    <!-- Quartier -->
                    <div>
                        <x-label for="district" value="Quartier / Arrondissement" />
                        <x-input id="district" type="text" name="district" class="block w-full mt-1"
                                 value="{{ old('district', $property->district) }}" />
                    </div>

                    <!-- Prix -->
                    <div>
                        <x-label for="price" value="Prix (FCFA)" />
                        <x-input id="price" type="number" step="0.01" name="price" class="block w-full mt-1"
                                 value="{{ old('price', $property->price) }}" required />
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <x-label for="phone" value="Téléphone de contact" />
                        <x-input id="phone" type="text" name="phone" class="block w-full mt-1"
                                 value="{{ old('phone', $property->phone) }}" required />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="4"
                                  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">{{ old('description', $property->description) }}</textarea>
                    </div>

                    <!-- Photos existantes -->
                    @if($property->images->count())
                        <div>
                            <x-label value="Photos actuelles" />
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2">
                                @foreach($property->images as $image)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-32 object-cover rounded shadow">
                                        <!-- Optionnel : bouton suppression -->
                                        <form method="POST" action="{{ route('property-images.destroy', $image) }}" class="absolute top-1 right-1">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-600 text-white text-xs px-2 py-1 rounded">X</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Ajouter de nouvelles photos -->
                    <div>
                        <x-label for="photos" value="Ajouter de nouvelles photos" />
                        <input type="file" id="photos" name="photos[]" multiple class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-between">
                        <a href="{{ route('properties.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Annuler
                        </a>
                        <x-button>
                            Mettre à jour
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
