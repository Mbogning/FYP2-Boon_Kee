<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bod',
        'phone',
        'gender',
        'status'
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

    public static function get_records($search)
    {
        $query = User::query();

        if (@$search['freetext']) {
            $query = $query->where('name', 'like', '%' . $search['freetext'] . '%');
        }

        $query->where('status', 'active');

        $result = $query->paginate(10);
        return $result;
    }

    // ? get customer listing for reservation
    public static function get_active_customer($customer_name = null)
    {
        $query = User::role('Customer');
        $query->where('status', 'active');

        if ($customer_name) {
            $query->where('name', 'like', '%' . $customer_name . '%');
        }

        $result = $query->get();
        return $result;
    }
}
