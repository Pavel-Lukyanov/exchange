<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $country
 * @property string $deleted_at
 * @property string $requisites
 */
class Organization extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'user_id',
        'name',
        'country',
        'city',
        'street',
        'house',
        'deleted_at',
        'requisites'
    ];

    public static function getOrganizations($data, $userId): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        try {
            $organizations = self::query()
                ->where('user_id', $userId)
                ->whereNull('deleted_at')
                ->paginate(config('defaults.pagination.per_page'));

            return $organizations;
        } catch (\Exception $e) {
            throw new \Exception('Error.');
        }
    }

    public static function show($userId, $id)
    {
        try {
            $organization = self::query()
                ->where(['user_id' => $userId, 'id' => $id])
                ->whereNull('deleted_at')
                ->firstOrFail();

            return $organization;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new \Exception('Organization is not found.');
        } catch (\Exception $e) {
            throw new \Exception('Произошла ошибка при получении организации.');
        }
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
