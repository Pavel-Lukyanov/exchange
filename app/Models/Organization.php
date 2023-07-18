<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $country
 * @property string $deleted_at
 */
class Organization extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'country',
        'city',
        'street',
        'house',
        'deleted_at'
    ];
}
