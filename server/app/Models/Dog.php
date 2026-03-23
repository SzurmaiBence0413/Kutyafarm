<?php

namespace App\Models;

use App\Models\Favourite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    /** @use HasFactory<\Database\Factories\DogFactory> */
    use HasFactory;
    protected function casts(): array
    {
        return [
            'teeth' => 'boolean',

        ];
    }
    protected $fillable = [
        'breedId' ,
        'dogName',
        'description',
        'userId',
        'dateOfBirth',
        'chipNumber',
        'gender',
        'colorId',
        'weight',
        'teeth',
    ];

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'dogId');
    }
}
