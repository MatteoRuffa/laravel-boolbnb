<?php

namespace App\Http\Controllers\Admin;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user(); // Recupera l'utente autenticato
        $apartments = $user->apartments;
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('admin.apartments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validateData = $request->validate([s
        //     'name' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'rooms' => 'required|integer|min:1',
        //     'beds' => 'required|integer|min:1',
        //     'bathrooms' => 'required|integer|min:1',
        //     'square_meters' => 'required|integer|min:1',
        //     'address' => 'required|string|max:255',
        //     'longitude' => 'required|numeric',
        //     'latitude' => 'required|numeric',
        //     'visibility' => 'required|boolean',
        //     'image_cover' => 'nullable|string|max:255',
        // ]);
        
        // $validatedData['slug'] = Apartment::generateSlug($validatedData['name']);
        // $validatedData['user_id'] = Auth::id();

        // Apartment::create($validatedData);

        // return redirect()->route('admin.apartments.index')->with('success', 'Apartment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        // $this->authorize('view', $apartments);
        // return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        // $this->authorize('update', $apartments);
        // return view('admin.apartments.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        // $this->authorize('update', $apartment);

        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'rooms' => 'required|integer|min:1',
        //     'beds' => 'required|integer|min:1',
        //     'bathrooms' => 'required|integer|min:1',
        //     'square_meters' => 'required|integer|min:1',
        //     'address' => 'required|string|max:255',
        //     'longitude' => 'required|numeric',
        //     'latitude' => 'required|numeric',
        //     'visibility' => 'required|boolean',
        //     'image_cover' => 'nullable|string|max:255',
        // ]);

        // $validatedData['slug'] = Apartment::generateSlug($validatedData['name']);

        // $apartment->update($validatedData);

        // return redirect()->route('admin.apartments.index')->with('success', 'Apartment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        // $this->authorize('delete', $apartment);
        // $apartment->delete();
        // return redirect()->route('admin.apartments.index')->with('success', 'Apartment deleted successfully.');
    }
}
