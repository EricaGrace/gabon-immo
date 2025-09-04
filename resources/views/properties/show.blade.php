<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $property->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <!-- Images -->
                @if($property->images->count())
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        @foreach($property->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                 class="w-full h-64 object-cover rounded-lg shadow" 
                                 alt="Photo du bien">
                        @endforeach
                    </div>
                @endif

                <!-- Infos principales -->
                <div class="mb-6">
                    <h3 class="text-2xl font-bold">{{ $property->title }}</h3>
                    <p class="text-lg text-gray-600 mt-1">{{ ucfirst($property->type) }} à {{ $property->city }} {{ $property->district ? '- '.$property->district : '' }}</p>
                    <p class="text-xl font-semibold text-blue-600 mt-2">{{ number_format($property->price, 0, ',', ' ') }} FCFA</p>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold">Description</h4>
                    <p class="text-gray-700 mt-2">{{ $property->description ?? 'Pas de description fournie.' }}</p>
                </div>

                <!-- Contact -->
                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-gray-800"><strong>Contact :</strong> {{ $property->phone }}</p>
                    <a href="tel:{{ $property->phone }}" 
                       class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                       Appeler maintenant
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
