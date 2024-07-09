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

        try {
            $lon = $request->input('longitude');
            $lat = $request->input('latitude');
            $radius = $request->input('radius');
            
            // Verifica che i parametri siano numerici
            //  if (!is_numeric($lat) || !is_numeric($lon) || !is_numeric($radius)) {
            //     throw new \Exception('I parametri latitude, longitude e radius devono essere numerici.');
            // }

            // Query per cercare gli appartamenti entro un certo raggio
            $query = "
                SELECT id, name, beds, bathrooms, visibility, description, rooms, square_meters, image_cover, address,
                ST_Distance_Sphere(location, POINT(?, ?)) AS distance 
                FROM apartments 
                HAVING distance <= ?
                ORDER BY distance
            ";

            $apartments = DB::select($query, [
                $lon,
                $lat,
                $radius * 1000 // Converti il raggio in metri
            ]);

            return response()->json([
                'success' => true,
                'results' => $apartments
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error in ApartmentController@index:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Si è verificato un errore durante il recupero degli appartamenti.',
                'error' => $e->getMessage()
            ], 500);
        }


    }
    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->with('user', 'services')->first();
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
