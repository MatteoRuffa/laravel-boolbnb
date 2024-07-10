<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 

class Search extends Model
{
    use HasFactory;
    public static function formatAddress($streetName, $houseNumber, $city, $cap)
    {
        $addressF = trim($streetName) . ' ' . trim($houseNumber) . ' ' . trim($city) . ' ' . trim($cap);
        return $addressF;
    }
    public static function apiFormatAddress($address)
    {
        $addressF = str_replace(' ', '%20', $address);
        return $addressF;
    }
    public function setLocationAttribute($latitude, $longitude)
    {
        if (isset($latitude) && isset($longitude)) {
            $this->attributes['location'] = DB::raw("ST_GeomFromText('POINT({$latitude} {$longitude})')");
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

