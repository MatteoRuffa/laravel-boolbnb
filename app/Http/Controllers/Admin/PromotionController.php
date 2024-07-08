<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    // Mostra il form per creare una nuova sponsorizzazione
     public function index()
    {
        // Recupera tutti gli appartamenti dell'utente autenticato
        $user = Auth::user();
        $apartments = Apartment::where('user_id', $user->id)->with('promotions')->get();

        // Filtra solo gli appartamenti che hanno almeno una sponsorizzazione
        $sponsoredApartments = $apartments->filter(function ($apartment) {
            return $apartment->promotions->isNotEmpty();
        });

        return view('admin.apartments.sponsorl.sponsor-index', ['apartments' => $sponsoredApartments]);

    }

    public function create(Apartment $apartment)
    {
        // Recupera tutti i pacchetti di sponsorizzazione disponibili
        $promotions = Promotion::all();

        // Recupera tutti gli appartamenti disponibili
        $apartments = Apartment::all();

        // Restituisce la vista con il form per creare una sponsorizzazione,
        // passando i dati relativi all'appartamento e ai pacchetti di sponsorizzazione
        return view('apartments.sponsorl.sponsor', compact('apartment', 'promotions', 'apartments'));
    }

    // Salva la sponsorizzazione
    public function store(Request $request)
    {
        // Trova l'appartamento specificato nel form tramite il suo ID
        $apartment = Apartment::findOrFail($request->apartment_id);

        // Controlla se l'appartamento è già sponsorizzato
        if ($this->isApartmentSponsored($apartment)) {
            // Se l'appartamento è già sponsorizzato, mostra un messaggio di errore
            return redirect()->back()->withErrors('Questo appartamento è già sponsorizzato.');
        }

        // Trova il pacchetto di sponsorizzazione specificato nel form tramite il suo ID
        $promotion = Promotion::findOrFail($request->promotion_id);

        // Effettua il redirect alla pagina di pagamento con i dettagli necessari
        return redirect()->route('payment.show', [
            'apartment_id' => $request->apartment_id,
            'promotion_id' => $request->promotion_id
        ]);
    }

    // Verifica se l'appartamento è già sponsorizzato
    private function isApartmentSponsored($apartment)
    {
        return $apartment->promotions()->exists();
    }

    // Mostra i dettagli della sponsorizzazione
    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->firstOrFail();
        $promotions = $apartment->promotions;
        return view('apartments.sponsorl.sponsor-show', compact('apartment', 'promotions'));
    }

    public function removeExpiredPromotions()
    {
        $now = Carbon::now();
        Apartment::whereHas('promotions', function ($query) use ($now) {
            $query->where('end_date', '<', $now);
        })->each(function ($apartment) use ($now) {
            $apartment->promotions()->wherePivot('end_date', '<', $now)->detach();
        });

        return response()->json(['status' => 'success']);
    }
}