<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'country',
        'city',
        'street',
        'house',
        'country',
        'deleted_at'
    ];
}
