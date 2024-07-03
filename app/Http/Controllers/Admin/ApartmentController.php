<?php

namespace App\Http\Controllers\Admin;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Promotion;
use App\Models\Service;


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
        $services= Service::all();
         return view('admin.apartments.create',compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['slug'] = Apartment::generateSlug($validatedData['name']);
        
        $validatedData['user_id'] = Auth::id();
        if ($request->hasFile('image_cover')) {
            $image_cover = Storage::put('img-apart-bnb', $request->image_cover);
            $validatedData['image_cover'] = $image_cover;
        }
        $client = new Client([
            'verify' => false,
        ]);
        $apiBaseUrl='https://api.tomtom.com/search/2/geocode/';
        $apiAdress= Apartment::apiFormatAddress($validatedData['address']);
        $response = $client->get( $apiBaseUrl . $apiAdress . '.json', [
            'query' => [
                'key' => env('TOMTOM_API_KEY'),
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['results'][0]['position'])) {
            $validatedData['latitude'] = $data['results'][0]['position']['lat'];
            $validatedData['longitude'] = $data['results'][0]['position']['lon'];
        } else {
            return back()->withErrors(['address' => 'Could not retrieve coordinates for the given address.']);
        }
        
        $new_apartment = new Apartment();
        $new_apartment->fill($validatedData);
        $new_apartment->visibility=0;
        $new_apartment->save();
        if($request->has('services')){
            $new_apartment->services()->sync($request->services);
        }

        return redirect()->route('admin.apartments.index')->with('success', 'Apartment created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        $promotions=Promotion::all();
        return view('admin.apartments.show', compact('apartment', 'promotions'));
    }
    // .nicolai
    //  public function promote(Request $request, Apartment $apartment)
    // {
    //     $this->authorize('update', $apartment);

    //     $promotionId = $request->input('promotion_id');
    //     $promotion = Promotion::findOrFail($promotionId);

    //     $apartment->addPromotion($promotion);

    //     return redirect()->route('admin.apartments.show', $apartment)->with('success', 'Appartamento sponsorizzato con successo');
    //  }
    // fine

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        if ($apartment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $services= Service::all();
        return view('admin.apartments.edit', compact('apartment','services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('image_cover')) {
            $image_cover = Storage::put('img-apart-bnb', $request->image_cover);
            $validatedData['image_cover'] = $image_cover;
            $apartment->image_cover=$validatedData['image_cover'];
        }
        if($apartment->name !== $validatedData['name']){
            $validatedData['slug'] = Apartment::generateSlug($validatedData['name']);
            $apartment->slug= $validatedData['slug'];
        }
        if($apartment->address !==  $validatedData['address']){
            $client = new Client([
                'verify' => false,
            ]);
            $apiBaseUrl='https://api.tomtom.com/search/2/geocode/';
            $apiAdress= Apartment::apiFormatAddress($validatedData['address']);
            $response = $client->get( $apiBaseUrl . $apiAdress . '.json', [
                'query' => [
                    'key' => env('TOMTOM_API_KEY'),
                ]
            ]);
    
            $data = json_decode($response->getBody(), true);
    
            if (isset($data['results'][0]['position'])) {
                $validatedData['latitude'] = $data['results'][0]['position']['lat'];
                $validatedData['longitude'] = $data['results'][0]['position']['lon'];
            } else {
                return back()->withErrors(['address' => 'Could not retrieve coordinates for the given address.']);
            }
            
        
        }
        $fields = ['name', 'description', 'rooms', 'bathrooms', 'beds', 'square_meters', 'address', 'latitude', 'longitude', 'slug', 'image_cover'];
        
        foreach ($fields as $field) {
            if (!isset($validatedData[$field])) {
                $validatedData[$field] = $apartment->$field;
            }
        }

        $apartment->fill($validatedData);
        $apartment->save();
        if($request->has('services')){
            $apartment->services()->sync($request->services);
        }
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
        $apartment->services()->detach();
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('message', "Apartment (id:{$apartment->id}): {$apartment->name} eliminate with succes from db");
       
    }
}
