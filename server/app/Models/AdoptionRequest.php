<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionRequest extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'dogId',
        'userId',
        'fullName',
        'email',
        'phone',
        'city',
        'message',
        'status',
    ];

    public function dog()
    {
        return $this->belongsTo(Dog::class, 'dogId');
    }
}
