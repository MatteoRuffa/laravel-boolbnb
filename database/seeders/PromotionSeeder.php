<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $promotions = [
            [
                'title' => 'Standard',
                'duration' => '24:00:00',
                'price' => 2.99,
                'description' => "L'appartamento sponsorizzato appare per 24h in Homepage nella sezione “Appartamenti in Evidenza” e nella pagina di ricerca, viene posizionato sempre prima di un appartamento non sponsorizzato che soddisfa le stesse caratteristiche di ricerca."
            ],
            [
                'title' => 'Plus',
                'duration' => '72:00:00',
                'price' => 5.99,
                'description' => "L'appartamento sponsorizzato appare per 48h in Homepage nella sezione “Appartamenti in Evidenza” e nella pagina di ricerca, viene posizionato sempre prima di un appartamento non sponsorizzato che soddisfa le stesse caratteristiche di ricerca."
            ],
            [
                'title' => 'Premium',
                'duration' => '144:00:00',
                'price' => 9.99,
                'description' => "L'appartamento sponsorizzato appare per 144h in Homepage nella sezione “Appartamenti in Evidenza” e nella pagina di ricerca, viene posizionato sempre prima di un appartamento non sponsorizzato che soddisfa le stesse caratteristiche di ricerca."
            ]
        ];

        foreach ($promotions as $promotionData) {
            // Creazione di una nuova istanza del modello Promotion
            $newPromotion = new Promotion();

            // Assegnazione dei valori dei campi
            $newPromotion->title = $promotionData['title'];
            $newPromotion->duration = $promotionData['duration'];
            $newPromotion->price = $promotionData['price'];
            $newPromotion->description = $promotionData['description'];

            // Salvataggio nel database
            $newPromotion->save();
        }
    }
}
