<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'dogId',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function dog()
    {
        return $this->belongsTo(Dog::class, 'dogId');
    }
}
