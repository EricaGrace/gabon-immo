<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $q = Property::where('user_id', Auth::id())
        ->with('images')
        ->latest();

    if ($search = request('q')) {
        $q->where(function($qq) use ($search){
            $qq->where('title', 'like', "%{$search}%")
               ->orWhere('city', 'like', "%{$search}%")
               ->orWhere('type', 'like', "%{$search}%");
        });
    }

    if ($status = request('status')) {
        $q->where('status', $status);
    }

    // 👇 la clé : renvoyer un paginator (LengthAwarePaginator)
    $properties = $q->paginate(12)->withQueryString();

    return view('properties.index', compact('properties'));
    }

    public function list(Request $request)
    {
        // Filtres
        $q         = $request->string('q')->toString();
        $city      = $request->string('city')->toString();
        $district  = $request->string('district')->toString();

        // Options des selects
        $cities = Property::where('status','published')
            ->whereNotNull('city')
            ->select('city')->distinct()->orderBy('city')->pluck('city');

        $districts = collect();
        if ($city) {
            $districts = Property::where('status','published')
                ->where('city', $city)
                ->whereNotNull('district')
                ->select('district')->distinct()->orderBy('district')->pluck('district');
        }

        // Requête principale
        $query = Property::where('status','published')
            ->with('images')
            ->orderBy('created_at','desc');

        if ($q) {
            $query->where(function($qq) use ($q) {
                $qq->where('title','like',"%{$q}%")
                   ->orWhere('city','like',"%{$q}%")
                   ->orWhere('district','like',"%{$q}%")
                   ->orWhere('type','like',"%{$q}%");
            });
        }
        if ($city) {
            $query->where('city', $city);
        }
        if ($district) {
            $query->where('district', $district);
        }

        $properties = $query->paginate(12)->withQueryString(); // paginator => links() OK

        return view('welcome',[
            'properties' =>$properties,
            'cities' => $cities,
            'districts' => $districts,
            'city' => $city,
            'district'=> $district,
            'q' => $q,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:studio,appartement,maison,terrain',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Créer la propriété
        $property = Property::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'type' => $request->type,
            'city' => $request->city,
            'district' => $request->district,
            'price' => $request->price,
            'description' => $request->description,
            'phone' => $request->phone,
        ]);

        // Sauvegarder les photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('properties', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                    'is_cover' => $index === 0, // première image comme photo principale
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('properties.index')->with('success', 'Propriété ajoutée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
       return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:studio,appartement,maison,terrain',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $property->update($request->only('title', 'type', 'city', 'district', 'price', 'description', 'phone'));

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('properties', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('properties.index')->with('success', 'Propriété mise à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', $property);

        // Supprimer les photos liées
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Propriété supprimée');
    }

    public function publish(Property $property) {
        $this->authorize('update', $property);
        $property->update(['status' => 'published']);
        return back()->with('success','Annonce publiée');
    }
    public function unpublish(Property $property) {
        $this->authorize('update', $property);
        $property->update(['status' => 'draft']);
        return back()->with('success','Annonce passée en brouillon');
    }
    public function archive(Property $property) {
        $this->authorize('update', $property);
        $property->update(['status' => 'archived']);
        return back()->with('success','Annonce archivée');
    }

}
