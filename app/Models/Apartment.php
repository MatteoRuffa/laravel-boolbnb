<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\User;
use App\Models\View;
use App\Models\Promotion;
use App\Models\ApartmentPromotion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
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

    public static function generateSlug($name){
        $slugBase = Str::slug(trim($name), '-');
        $slugs = \App\Models\Apartment::orderBy('slug')->pluck('slug')->toArray();
        $num = 1;
        $slugNumbers = [];
        
        foreach ($slugs as $slug) {
            if (preg_match('/-(\d+)$/', $slug, $matches)) {
                $slugNumbers[] = intval($matches[1]);
            }
        }

        while (in_array($num, $slugNumbers)) {
            $num++;
        }

        $slug = $slugBase . '-' . $num;

        if(preg_match('/-(\d+)$/', $slugBase, $matches)){
            if(!in_array($matches[1],$slugNumbers)){
                $slug=$slugBase;   
            }
        }
        return $slug;
    }

    public static function formatAddress($streetName,$houseNumber,$city,$cap){
        $addressF = trim($streetName).' '.trim($houseNumber).' '.trim($city).' '.trim($cap);
        return  $addressF;
    }
    public static function apiFormatAddress($address){
        $addressF = str_replace(' ','%20',$address);
        return  $addressF;
    }
    public function setLocationAttribute($latitude, $longitude)
    {
        if (isset($value['latitude']) && isset($value['longitude'])) {
            $this->attributes['location'] = DB::raw("ST_GeomFromText('POINT({$value['latitude']} {$value['longitude']})')");
        }
    }
    public function getLocationAttribute($value)
    {
        $coords = sscanf($value, 'POINT(%f %f)');
        return [
            'latitude' => $coords[0],
            'longitude' => $coords[1],
        ];
    }
}
