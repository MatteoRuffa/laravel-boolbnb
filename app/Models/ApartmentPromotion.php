<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Promotion;
use App\Models\Apartment;
use App\Models\User;
use App\Models\View;
use App\Models\Service;

class ApartmentPromotion extends Model
{
    use HasFactory;

    protected $table = 'apartment_promotion';

    protected $fillable = [
        'apartment_id',
        'promotion_id',
        'start_date',
        'end_date',
        
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    //nicolai
    // public function timeRemaining() {
    //     $now = Carbon::now();
    //     return $now->diffForHumans($this->end_date, true);
    // }
    //fine
}
