<?php

namespace App\Models;

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
        'userId',
        'dateOfBirth',
        'chipNumber',
        'gender',
        'colorId',
        'weight',
        'teeth',
    ];
}
