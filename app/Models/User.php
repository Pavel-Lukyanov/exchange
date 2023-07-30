<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * @property int $id
 * @property string $firstname
 * @property string $surname
 * @property string $patronymic
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $flat
 * @property string $birthday
 * @property string $date_medical_examination
 * @property string $position
 * @property string $deleted_at
 * @property string $phone
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'firstname',
        'surname',
        'patronymic',
        'email',
        'password',
        'city',
        'street',
        'house',
        'flat',
        'birthday',
        'date_medical_examination',
        'position',
        'deleted_at',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employees::class, 'user_id', 'id'); // Один к одному
    }

    public static function searchUsers($data): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $users = self::query()
            ->when(isset($data['search']), function($q) use ($data) {
               $q->where('firstname', 'LIKE', '%' . $data['search'] . '%')
                   ->orWhere('surname', 'LIKE', '%' . $data['search'] . '%')
                   ->orWhere('patronymic', 'LIKE', '%' . $data['search'] . '%');
            })
            ->paginate(config('defaults.pagination.per_page'));

        return $users;
    }
}
