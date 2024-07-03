<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\User;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $apartments = Apartment::all();
        //   dd($apartments);
        return response()->json([
            'success' => true,
            'message' => 'Ok',
            'results' => $apartments
        ], 200);
    }
    // public function show($slug)
    // {
    //     $apartment = Apartment::where('slug', $slug)->with('user', 'service')->first();
    //     if($apartment){
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Ok',
    //             'results' => $apartment
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'apartment not found'
    //         ], 404);
    //     }
    // }
}
