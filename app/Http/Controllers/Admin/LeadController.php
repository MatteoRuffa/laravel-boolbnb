<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Lead::paginate(20);
        $totalMessage = DB::table('apartments')->count();
        return view('admin.leads.index', compact('messages', 'totalMessage'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $message)
    {
        //
    }
}
