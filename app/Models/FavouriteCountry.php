<?php

namespace App\Models;

use Database\Factories\FavouriteCountryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteCountry extends Model
{
    /** @use HasFactory<FavouriteCountryFactory> */
    use HasFactory;
}
