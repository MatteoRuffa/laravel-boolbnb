<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Apartment;
use App\Models\ApartmentPromotion;
class Promotion extends Model
{
    use HasFactory;
    protected $fillable = [
        'duration',
        'price',
        'title'
    ];

    //Relazione uno a molti tra promozioni e appartamenti (tabella pivot)
    public function apartments(){
        return $this->belongsToMany(Apartment::class)->using(ApartmentPromotion::class);
    }

}
