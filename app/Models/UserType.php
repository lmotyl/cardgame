<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public const TYPE_HUMAN = 1;
    public const TYPE_CPU = 2;

    protected $fillable = [
        'user_id',
        'type'
    ];

}
