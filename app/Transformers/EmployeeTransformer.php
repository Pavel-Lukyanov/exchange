<?php

namespace App\Transformers;

use App\Models\Employees;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
//        'user'
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
    public function transform(Employees $employees)
    {
        return [
            'id'=>$employees->id,
            'user_id'=>$employees->user_id,
            'object_id'=>$employees->object_id,
        ];
    }

//    public function includeUser(Employees $employees): \League\Fractal\Resource\Item
//    {
//        return $this->item($employees->user, new UserMainInfoTransformer(), 'user');
//    }
}
