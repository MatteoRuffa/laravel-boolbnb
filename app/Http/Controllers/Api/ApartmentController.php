<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('services')) {
            $apartments = Apartment::with('services')->where('apartment_service.service_id', $request->query('services'))->get();
            //dd($apartments);
        } else {
            $apartments = Apartment::with('services')->get();
        }
        return response()->json([
            'success' => true,
            'message' => 'Ok',
            'results' => $apartments
        ], 200);
    }
    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->with('user', 'service')->first();
        if ($apartment) {
            return response()->json([
                'success' => true,
                'message' => 'Ok',
                'results' => $apartment
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'apartment not found'
            ], 404);
        }
    }
    //     public function searchNearby(Request $request)
    // {
    //     $validated = $request->validate([
    //         'latitude' => 'required|numeric',
    //         'longitude' => 'required|numeric',
    //         'radius' => 'required|numeric',
    //     ]);

        // Ottieni i parametri di ricerca dalla richiesta
        // $latitude = $request->input('latitude');
        // $longitude = $request->input('longitude');
        // $radius = $request->input('radius');
        
        // Calcola la distanza e recupera gli appartamenti nelle vicinanze
        // $filteredApartments = Apartment::selectRaw("*, (
        //     6371 * acos(
        //         cos(radians(?)) *
        //         cos(radians(latitude)) *
        //         cos(radians(longitude) - radians(?)) +
        //         sin(radians(?)) *
        //         sin(radians(latitude))
        //     )
        //     ) AS distance", [$latitude, $longitude, $latitude])
        //     ->having('distance', '<', $radius)
        //     ->orderBy('distance')
        //     ->get();


        // Rispondi con i risultati trovati
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Appartamenti trovati con successo.',
        //     'results' => $filteredApartments
        // ], 200);
    // }


}
