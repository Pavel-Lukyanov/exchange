<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicedObject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'city',
        'street',
        'house',
        'contract_number',
        'contract_date_start',
        'contract_date_end',
        'type_installation',
        'name_organization_do_project',
        'project_release_date',
        'organization_name_mounting',
        'date_delivery_object',
        'services_schedule',
        'description_object',
        'scheme',
        'loop_lists',
        'photos',
        'user_id',
        'is_archived',
        'is_completed'
    ];

    public function employees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Employees::class, 'object_id'); // Многие к одному
    }
}
