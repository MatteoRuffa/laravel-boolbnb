<?php

namespace App\Http\Controllers\Admin;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user(); // Recupera l'utente autenticato
        $apartments = $user->apartments()->paginate(10);
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.apartments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        $validateData = $request->validated();
        $validatedData['slug'] = Apartment::generateSlug($validateData['name']);
        
        $validatedData['user_id'] = Auth::id();
        $new_apartment = new Apartment();
        if ($request->hasFile('image_cover')) {
            $image_cover = Storage::put('img-apart-bnb', $request->image_cover);
            $validatedData['image_cover'] = $image_cover;
            $new_apartment->image_cover=$validatedData['image_cover'];
        }
        
        $new_apartment->fill($validateData);
        $new_apartment->slug= $validatedData['slug'];
        $new_apartment->longitude=1;
        $new_apartment->latitude=1;
        $new_apartment->visibility=0;
        $new_apartment->user_id= $validatedData['user_id'];
        $new_apartment->save();

        return redirect()->route('admin.apartments.index')->with('success', 'Apartment created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        if ($apartment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.apartments.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $validateData = $request->validated();
        if ($request->hasFile('image_cover')) {
            $image_cover = Storage::put('img-apart-bnb', $request->image_cover);
            $validatedData['image_cover'] = $image_cover;
            $apartment->image_cover=$validatedData['image_cover'];
        }
        if($apartment->name !== $validateData['name']){
            $validatedData['slug'] = Apartment::generateSlug($validateData['name']);
            $apartment->slug= $validatedData['slug'];
        }
        $apartment->fill($validateData);
        $apartment->save();
        return view('admin.apartments.show', compact('apartment'));
        // $project_modified =  Project::findOrFail($id);
        // $form_data = $request->validated();
        // if ($request->hasFile('image_url')) {
        //     if ($project_modified->image_url) {
        //         Storage::delete($project_modified->image_url);
        //     }
        //     $img_path = Storage::put('my_images', $request->image_url);
        //     $form_data['image_url'] = $img_path;
        // }
        // if ($project_modified->title != $form_data["title"]) {
        //     $form_data["slug"] =  Project::generateSlug($form_data["title"]);
        // }
        // $project_modified->fill($form_data);
        // $project_modified->update();
        // return redirect()->route("admin.projects.index")->with('message', "Project (id:{$project_modified->id}): {$project_modified->title} modified successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $apartment = Apartment::findOrFail($id);
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('message', "Apartment (id:{$apartment->id}): {$apartment->name} eliminate with succes from db");
    }
}
