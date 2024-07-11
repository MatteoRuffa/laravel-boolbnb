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
            $beds = $request->input('beds');
            $bathrooms = $request->input('bathrooms');
            $services = $request->input('services'); // Assumi che sia un array di ID dei servizi
    
            // Verifica che i parametri siano numerici
            if (!is_numeric($lat) || !is_numeric($lon) || !is_numeric($radius)) {
                throw new \Exception('I parametri latitude, longitude e radius devono essere numerici.');
            }
    
            // Base query per cercare gli appartamenti entro un certo raggio
            $query = "
                SELECT a.id, a.slug, a.name, a.beds, a.bathrooms, a.visibility, a.description, a.rooms, 
                       a.square_meters, a.image_cover, a.address, a.latitude, a.longitude,
                       ST_Distance_Sphere(a.location, POINT(?, ?)) AS distance 
                FROM apartments a
                WHERE 1 = 1
            ";
    
            $bindings = [$lon, $lat]; // Parametri iniziali per la query
    
            // Aggiungi condizioni per i letti e i bagni usando switch
            switch (true) {
                case isset($beds):
                    $query .= " AND a.beds >= ?";
                    $bindings[] = $beds;
                    break;
    
                case isset($bathrooms):
                    $query .= " AND a.bathrooms >= ?";
                    $bindings[] = $bathrooms;
                    break;
    
                case !empty($services):
                    $serviceCount = count($services);
                    $query .= " AND a.id IN (
                        SELECT apartment_id 
                        FROM apartment_service 
                        WHERE service_id IN (" . implode(',', $services) . ")
                        GROUP BY apartment_id
                        HAVING COUNT(DISTINCT service_id) = ?
                    )";
                    $bindings[] = $serviceCount;
                    break;
            }
    
            $query .= " HAVING distance <= ? ORDER BY distance";
            $bindings[] = $radius * 1000; // Converti il raggio in metri
    
            $apartments = DB::select($query, $bindings);
    
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
}
