<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenusType extends Model
{
    protected $table = "menus_type";
    protected $fillable = [
        'name',
        'status'
    ];

    public static function get_all()
    {
        $query = MenusType::query()->where('status', 'active')->paginate(5);
        return $query;
    }

    public static function get_menu_type()
    {
        $query = MenusType::query()->where('status', 'active')->get();
        $result = [];
        foreach ($query as $key => $value) {
            $result[$value->id] = $value->name;
        }

        return $result;
    }

    public static function get_menu_types()
    {
        $query = MenusType::query()->where('status', '!=', 'deleted')->get();
        return $query;
    }
}
