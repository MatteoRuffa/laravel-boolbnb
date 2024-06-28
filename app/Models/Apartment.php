<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Service;
// use App\Models\User;
use App\Models\View;
use App\Models\Promotion;
use App\Models\ApartmentPromotion;
use Carbon\Carbon;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'name', 
        'slug', 
        'description',
        'rooms', 
        'beds', 
        'bathrooms',
        'square_meters',
        'image_cover',
        'address',
        'longitude',
        'latitude',
        'visibility'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'apartment_promotion')
                    ->withPivot('start_date', 'end_date');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'apartment_service');
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public static function generateSlug($name)
    {
        $slugBase = Str::slug(trim($name), '-');
        $existingSlugs = \App\Models\Apartment::where('slug', 'like', $slugBase . '%')
                                               ->pluck('slug')
                                               ->toArray();

        if (!in_array($slugBase, $existingSlugs)) {
            return $slugBase;
        }

        $num = 1;
        while (in_array($slugBase . '-' . $num, $existingSlugs)) {
            $num++;
        }

        return $slugBase . '-' . $num;
    }

    public function isPromoted()
    {
        $now = Carbon::now();
        return $this->promotions()->wherePivot('start_date', '<=', $now)
                                  ->wherePivot('end_date', '>=', $now)
                                  ->exists();
    }
}
