<?php

namespace App\Transformers;

use App\Models\ServicedObject;
use League\Fractal\TransformerAbstract;

class ServicedObjectTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        'employees'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(ServicedObject $object)
    {
        return [
            'id' => $object->id,
            'user_id' => $object->user_id,
            'employee_id' => $object->employee_id,
            'name' => $object->name,
            'country' => $object->country,
            'city' => $object->city,
            'street' => $object->street,
            'house' => $object->house,
            'contract_number' => $object->contract_number,
            'contract_date_start' => $object->contract_date_start,
            'contract_date_end' => $object->contract_date_end,
            'type_installation' => $object->type_installation,
            'name_organization_do_project' => $object->name_organization_do_project,
            'project_release_date' => $object->project_release_date,
            'organization_name_mounting' => $object->organization_name_mounting,
            'date_delivery_object' => $object->date_delivery_object,
            'services_schedule' => $object->services_schedule,
            'description_object' => $object->description_object,
            'scheme' => $object->scheme,
            'loop_lists' => $object->loop_lists,
            'photos' => $object->photos,
            'is_archived' => $object->is_archived,
            'is_completed' => $object->is_completed,
        ];
    }

    public function includeEmployees(ServicedObject $object): \League\Fractal\Resource\Collection
    {
        return $this->collection($object->employees, new EmployeeTransformer(), 'employees');
    }
}
