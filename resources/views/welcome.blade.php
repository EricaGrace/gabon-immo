<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] p-6 min-h-screen">

    <!-- Header minimal avec login/register -->
    <header class="w-full max-w-6xl mx-auto mb-6">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded-sm hover:bg-white">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 border rounded-sm hover:bg-white">Se connecter</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 border rounded-sm hover:bg-white">S'inscrire</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="w-full max-w-6xl mx-auto">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <!-- Formulaire de recherche -->
                <form method="GET" class="flex flex-wrap gap-3 w-full">
                    <!-- Recherche -->
                    <x-input type="text" name="q" value="{{ $q ?? '' }}"
                            placeholder="Rechercher (titre, type…)"
                            class="w-150 md:w-64" />

                    <!-- Ville -->
                    <select name="city" class="border-gray-300 rounded-md w-50 md:w-48">
                        <option value="">Toutes les villes</option>
                        @foreach($cities as $c)
                            <option value="{{ $c }}" @selected(($city ?? '') === $c)>{{ $c }}</option>
                        @endforeach
                    </select>

                    <!-- Quartier 
                    <select name="district" class="border-gray-300 rounded-md w-full md:w-48"
                            {{ empty($city) ? 'disabled' : '' }}>
                        <option value="">{{ empty($city) ? 'Choisissez une ville' : 'Tous les quartiers' }}</option>
                        @foreach($districts as $d)
                            <option value="{{ $d }}" @selected(($district ?? '') === $d)>{{ $d }}</option>
                        @endforeach
                    </select> -->

                    <!-- Bouton -->
                    <x-button class="w-50 md:w-auto">
                        Filtrer
                    </x-button>

                    <!-- Reset -->
                    @if($city || $district || $q)
                        <a href="{{ route('home') }}" class="text-sm text-gray-600 underline underline-offset-4">
                            Réinitialiser
                        </a>
                    @endif
                </form>
                <!-- CTA Owner uniquement -->
                @auth
                    @if(auth()->user()->role === 'owner')
                        <a href="{{ route('properties.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            + Ajouter un bien
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Liste des annonces publiées -->
            @if($properties->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($properties as $property)
                        <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                            @php
                                $cover = $property->images->firstWhere('is_cover', true) ?? $property->images->first();
                            @endphp
                            @if($cover)
                                <img src="{{ asset('storage/'.$cover->image_path) }}" class="w-full h-48 object-cover" alt="Photo du bien">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">Pas de photo</span>
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="text-lg font-semibold line-clamp-1">{{ $property->title }}</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ ucfirst($property->type) }} — {{ $property->city }}
                                    {{ $property->district ? '('.$property->district.')' : '' }}
                                </p>
                                <p class="text-blue-600 font-bold mt-2">
                                    {{ number_format($property->price, 0, ',', ' ') }} FCFA
                                </p>

                                <a href="{{ route('properties.show', $property) }}"
                                   class="inline-block mt-3 text-blue-600 hover:underline">Voir le détail</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $properties->links() }}
                </div>
            @else
                <p class="text-gray-600">Aucune annonce publiée ne correspond à vos filtres.</p>
            @endif
        </div>
    </main>
</body>
</html>
