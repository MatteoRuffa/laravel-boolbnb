<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;

use App\Models\User;
use Illuminate\Support\Facades\DB;


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
       
        $cleanApartments = $apartments->map(function ($apartment) {
            $data = $apartment->toArray();
            // Rimuovi il campo 'location'
            unset($data['location']);
            return $data;
        });


    }


    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->with('user', 'services')->first();

        if ($apartment) {
            // Converti l'appartamento in un array e rimuovi il campo 'location'
            $data = $apartment->toArray();
            unset($data['location']);

            // Restituisci l'appartamento con i dati aggiornati
              return response()->json([
                'success' => true,
                'message' => 'Ok',
                'results' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'apartment not found'
            ], 404);
        }
    }
    public function searchNearby(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
        ]);

        // Ottieni i parametri di ricerca dalla richiesta
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');

        // Calcola la distanza e recupera gli appartamenti nelle vicinanze
        $filteredApartments = Apartment::selectRaw("*, (
            6371 * acos(
                cos(radians(?)) *
               cos(radians(latitude)) *
                cos(radians(longitude) - radians(?)) +
              sin(radians(?)) *
                sin(radians(latitude))
            )
             ) AS distance", [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->get();


        // Rispondi con i risultati trovati
        return response()->json([
            'success' => true,
            'message' => 'Appartamenti trovati con successo.',
            'results' => $filteredApartments
        ], 200);
    }


}
