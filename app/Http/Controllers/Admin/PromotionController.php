<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Promotion;
use Carbon\Carbon;
use App\Http\Controllers\Controller;


class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::all();
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    //nicolai
    // public function store(Request $request, Apartment $apartment)
    // {
    //     $this->authorize('update', $apartment);

    //     $promotionId = $request->input('promotion_id');
    //     $promotion = Promotion::findOrFail($promotionId);

    //     $apartment->addPromotion($promotion);

    //     return redirect()->route('apartments.show', $apartment)->with('success', 'Appartamento sponsorizzato con successo');
    // }
    //fine

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        //
    }
}
