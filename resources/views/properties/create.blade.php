<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publier un bien immobilier') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                
                <!-- Message de succès / erreurs -->
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

                <!-- Formulaire -->
                <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Titre -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Titre de l’annonce</label>
                        <input type="text" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Ex : Studio meublé à Akébé" required>
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Type de bien</label>
                        <select name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Choisir --</option>
                            <option value="studio">Studio</option>
                            <option value="appartement">Appartement</option>
                            <option value="maison">Maison</option>
                            <option value="chambre">Chambre</option>
                        </select>
                    </div>

                    <!-- Ville -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Ville</label>
                        <input type="text" name="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Libreville, Port-Gentil..." required>
                    </div>

                    <!-- Quartier -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Quartier / Arrondissement</label>
                        <input type="text" name="district" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Ex : Nzeng Ayong">
                    </div>

                    <!-- Prix -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Prix</label>
                        <input type="number" step="0.01" name="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Ex : 150000" required>
                        <p class="text-sm text-gray-500">Indiquez le prix en FCFA.</p>
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Téléphone de contact</label>
                        <input type="text" name="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="+241..." required>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Description</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Décrivez le bien (surface, équipements, conditions...)"></textarea>
                    </div>

                    <!-- Photos -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Photos</label>
                        <input type="file" name="photos[]" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <p class="text-sm text-gray-500">Ajoutez jusqu’à 5 photos (.jpg, .png, max 2MB chacune)</p>
                    </div>

                    <!-- Bouton -->
                    <div class="flex justify-end">
                        <x-button type="submit">
                            {{ __('Publier mon annonce') }}
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

