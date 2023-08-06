<?php

namespace App\Transformers;

use App\Models\Organization;
use League\Fractal\TransformerAbstract;

class OrganizationTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
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
    public function transform(Organization $organization)
    {
        return [
            'id' => $organization->id,
            'user_id' => $organization->user_id,
            'name' => $organization->name,
            'country' => $organization->country,
            'city' => $organization->city,
            'street' => $organization->street,
            'house' => $organization->house,
            'requisites' => $organization->requisites,
            'deleted_at' => $organization->deleted_at,
        ];
    }

}
