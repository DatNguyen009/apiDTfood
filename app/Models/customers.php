<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    use HasFactory;
    protected $fillable = [
        'customers_id',
        'customers_name',
        'customers_email',
        'customers_password',
        'customers_address',
        'customer_phone',
        'isDeleted',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'customer_phone' => 'integer'
    ];
}

// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\User as Authenticatable;

// class customers extends Authenticatable
// {
//     use Notifiable;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array
//      */
//     protected $fillable = [
//         'customers_email', 'password',
//     ];

//     /**
//      * The attributes that should be hidden for arrays.
//      *
//      * @var array
//      */
//     protected $hidden = [
//         'password', 'remember_token',
//     ];
// }
