<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'firstname' => $user->firstname,
            'surname' => $user->surname,
            'patronymic' => $user->patronymic,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'city' => $user->city,
            'street' => $user->street,
            'house' => $user->house,
            'flat' => $user->flat,
            'birthday' => $user->birthday,
            'date_medical_examination' => $user->date_medical_examination,
            'position' => $user->position,
            'deleted_at' => $user->deleted_at,
            'phone' => $user->phone
        ];
    }
}
