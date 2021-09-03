<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class administrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'nameAdmin',
        'password',
        'remember_token'
    ];
    public $timestamps = false;
}
