<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $serviced_object_id
 * @property int $user_id
 */
class Employee extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'serviced_object_id',
        'user_id'
    ];

    public function object(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ServicedObject::class, 'serviced_object_id', 'id'); // Один ко многим
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class); // Один к одному
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
