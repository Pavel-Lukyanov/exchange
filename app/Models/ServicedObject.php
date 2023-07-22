<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $employee_id
 * @property string $name
 * @property string $country
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $contract_number
 * @property Carbon $contract_date_start
 * @property Carbon $contract_date_end
 * @property string $type_installation
 * @property string $name_organization_do_project
 * @property Carbon $project_release_date
 * @property string $organization_name_mounting
 * @property Carbon $date_delivery_object
 * @property string $services_schedule
 * @property string $description_object
 * @property string $scheme
 * @property string $loop_lists
 * @property string $photos
 * @property boolean $is_archived
 * @property boolean $is_completed
 */
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
        return $this->hasMany(Employees::class, 'serviced_object_id'); // Многие к одному
    }

    public function customers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Employees::class, 'serviced_object_id'); // Многие к одному
    }

    public static function getObjects($data, $userId): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $objects = self::query()
            ->where('user_id', $userId)
            ->when(isset($data['is_completed']), function ($q) use ($data) {
                $q->where('is_completed', $data['is_completed']);
            })
            ->when(isset($data['sort']), function($q) use ($data) {
                $q->orderBy($data['sort'], 'desc');
            })
            ->paginate(config('defaults.pagination.per_page'));

        return $objects;
    }

    public static function searchObjects($data, $userId): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $objects = self::query()
            ->where('user_id', $userId)
            ->when(isset($data['search']), function ($q) use ($data) {
                $q->where('name', 'LIKE', '%' . $data['search'] . '%')
                    ->orWhere('street', 'LIKE', '%' . $data['search'] . '%');
            })
            ->paginate(config('defaults.pagination.per_page'));

        return $objects;
    }

    /*public static function createObject(array $data)
    {
        $object = (new self())->create([
            'name' => $data['name'] ?? null,
            'user_id' => $data['user_id']
        ]);

        return $object;
    }*/
}
