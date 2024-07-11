<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Search;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {

     
        try {
            $lon = (float) $request->input('longitude');
            $lat = (float) $request->input('latitude');
            $radius = (int) $request->input('radius');
            $beds = (int) $request->input('beds');
            $bathrooms = (int) $request->input('bathrooms');
            $rooms = (int) $request->input('rooms');
            $services = $request->input('services', []); // Assumi che sia un array di ID dei servizi
    
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
    
            $bindings = [$lat, $lon]; // Parametri iniziali per la query
            // Aggiungi condizioni per i letti ,i bagni e stanze usando switch
            if ($beds !== null) {
                $query .= " AND a.beds >= ?";
                $bindings[] = $beds;
            } 
            if ($bathrooms !== null) {
                $query .= " AND a.bathrooms >= ?";
                $bindings[] = $bathrooms;
            } if ($rooms !== null) {
                $query .= " AND a.rooms >= ?";
                $bindings[] = $rooms;
            }
            // Aggiungi filtro per i servizi se presenti
            if (!empty($services)) {
                $serviceIds = array_map('intval', $services);
                $serviceCount = count($serviceIds);
    
                $placeholders = implode(',', array_fill(0, $serviceCount, '?'));
    
                $query .= " AND a.id IN (
                    SELECT apartment_id 
                    FROM apartment_service 
                    WHERE service_id IN ($placeholders)
                    GROUP BY apartment_id
                    HAVING COUNT(DISTINCT service_id) = ?
                )";
    
                $bindings = array_merge($bindings, $serviceIds, [$serviceCount]);
            }
    
            $query .= " HAVING distance <= ? ORDER BY distance";
            $bindings[] = $radius * 1000; // Converti il raggio in metri
    
            $apartments = DB::select($query, $bindings);
    
            return response()->json([
                'success' => true,
                'results' => $apartments
            ], 200);
    
        } catch (\Exception $e) {
            \Log::error('Error in SearchController@index:', ['error' => $e->getMessage()]);
    
            return response()->json([
                'success' => false,
                'message' => 'Si è verificato un errore durante il recupero degli appartamenti.',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
