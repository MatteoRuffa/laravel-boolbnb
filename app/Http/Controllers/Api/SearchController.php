<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lon = $request->input('longitude');
            $lat = $request->input('latitude');
            $radius = $request->input('radius');
            $beds = $request->input('beds', 0);
            $rooms = $request->input('rooms', 0);
            $selectedServices = $request->input('services', []);

            if (!is_array($selectedServices)) {
                throw new \Exception('Il parametro services deve essere un array.');
            }

            // Inizializzazione della query principale
            $query = "
                SELECT a.id, a.slug, a.name, a.beds, a.bathrooms, a.visibility, a.description, a.rooms, a.square_meters, a.image_cover, a.address,
                    ST_Distance_Sphere(a.location, POINT(?, ?)) AS distance 
                FROM apartments a
            ";

            $params = [$lon, $lat];

            // Aggiunta della clausola di filtro per i servizi se sono presenti servizi selezionati
            if (count($selectedServices) > 0) {
                $query .= "
                    JOIN (
                        SELECT apartment_id
                        FROM apartment_service
                        WHERE service_id IN (" . implode(',', array_fill(0, count($selectedServices), '?')) . ")
                        GROUP BY apartment_id
                        HAVING COUNT(DISTINCT service_id) = ?
                    ) as filtered_apartments ON a.id = filtered_apartments.apartment_id
                ";
                $params = array_merge($params, $selectedServices, [count($selectedServices)]);
            }

            $query .= "
                WHERE a.beds >= ? AND a.rooms >= ?
                HAVING distance <= ?
                ORDER BY distance
            ";

            $params = array_merge($params, [$beds, $rooms, $radius * 1000]);

            $apartments = DB::select($query, $params);

            return response()->json([
                'success' => true,
                'results' => $apartments
            ], 200);
            if (empty($apartments)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Nessun appartamento trovato con i criteri specificati.',
                    'results' => []
                ], 204); // No Content
            }

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
