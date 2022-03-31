<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = "menus";
    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'status',
    ];

    public static function get_all()
    {
        $query = Menus::query();
        $query->where('status', '!=', 'deleted');
        $result = $query->paginate(15);
        return $result;
    }
}
