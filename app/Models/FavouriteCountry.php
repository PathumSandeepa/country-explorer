<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteCountry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country_code',
        'name',
        'capital',
        'flag_url',
        'personal_note',
    ];
}
