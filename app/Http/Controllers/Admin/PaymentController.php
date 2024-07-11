<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Models\Promotion;
use Braintree\Gateway;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class PaymentController extends Controller
{
    // Metodo per visualizzare il modulo di pagamento  
    public function show(Request $request, Gateway $gateway)
    {
        $apartment_id = $request->input('apartment_id');
        $promotion_id = $request->input('promotion_id');
        $promotion = Promotion::findOrFail($promotion_id);
        $price = $promotion->price;
        $title = $promotion->title;
        $duration = $promotion->duration;



        $clientToken = $gateway->clientToken()->generate();

        return view('admin.apartments.payment.form', compact('apartment_id', 'promotion_id', 'price', 'clientToken', 'title', 'duration'));
    }

    public function process(Request $request)
    {
        // Recupera i dati necessari dal request
        $apartment_id = $request->input('apartment_id');
        $promotion_id = $request->input('promotion_id');

        // Trova il prezzo del pacchetto di sponsorizzazione
        $promotion = Promotion::findOrFail($promotion_id);
        $duration = $promotion->duration;
        

        // Imposta la data di inizio della sponsorizzazione come l'ora corrente
        $start_date = now();

        // Converte l'orario in ore, minuti e secondi
        list($hours, $minutes, $seconds) = explode(':', $duration);
        $start_date = Carbon::parse($start_date);

        // Calcola la data di fine della sponsorizzazione aggiungendo la durata del pacchetto di sponsorizzazione
        $end_date = $start_date->copy()->addHours($hours)->addMinutes($minutes)->addSeconds($seconds);

        // Salva la sponsorizzazione nel database evitando duplicati
        $apartment = Apartment::findOrFail($apartment_id);
        $existingPromotion = $apartment->promotions()
            ->where('promotion_id', $promotion_id)
            ->first();

            if ($existingPromotion) {
                // Se la promozione esiste già, aggiorna la data di fine
                $current_end_date = Carbon::parse($existingPromotion->pivot->end_date);
        
                // Somma il nuovo periodo alla fine corrente
                $new_end_date = $current_end_date->greaterThan($end_date) ? $current_end_date->copy()->addHours($hours)->addMinutes($minutes)->addSeconds($seconds) : $end_date;
        
                $apartment->promotions()->updateExistingPivot($promotion_id, [
                    'start_date' => $start_date,
                    'end_date' => $new_end_date,
                ]);
            } else {
                // Altrimenti, attacca la nuova promozione
                $apartment->promotions()->attach($promotion_id, [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);
            }

        // Passa i dati necessari per la vista success
        return redirect()->route('admin.payment.success')
            ->with([
                'apartment' => $apartment,
                'promotions' => $apartment->promotions
            ]);
    }

    // Metodo per visualizzare la ponsorizzazione dopo il pagamento
    public function success()
    {
        // Recupera l'oggetto apartment dalla sessione
        // $apartment = session('apartment');
        // $promotions = session('promotions');


        // Verifica che apartment non sia null
        // if (!$apartment || !$promotions) {
        //     return redirect()->route('admin.sponsor.create')->withErrors('Dati non trovati per visualizzare la sponsorizzazione.');
        // }

        session()->flash('success', 'Pagamento completato con successo!');


        return redirect()
            ->back();
    }
}