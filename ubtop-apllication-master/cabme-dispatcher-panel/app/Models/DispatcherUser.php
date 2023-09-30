<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispatcherUser extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;



    /**

     * The attributes that are mass assignable.

     *

     * @var array<int, string>

     */
    protected $table = 'dispatcher_user';
    protected $fillable = [

        'id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'status',
        'profile_picture',
        'profile_picture_path',
        'remember_token',
        'created_at',
        'updated_at',


    ];

}


