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
        'house_number',
        'number_contract',
        'date_start_contract',
        'date_end_contract',
        'type_installation',
        'name_organization_do_project',
        'project_release_date',
        'name_organization_performed_installation_commissioning',
        'date_delivery_object',
        'services_chedule',
        'description_object',
        'installation_composition',
        'scheme',
        'loop_lists',
        'photos',
        'user_id',
    ];
}
