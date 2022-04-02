<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Menus extends Model
{
    use HasSlug;

    protected $table = "menus";
    protected $fillable = [
        'name',
        'description',
        'slug',
        'price',
        'type',
        'status',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public static function get_all()
    {
        $query = Menus::query();
        $query->where('status', '!=', 'deleted');
        $result = $query->paginate(15);
        return $result;
    }

    public static function get_active_menu()
    {
        $query = Menus::query()->where('status', 'active')->get();
        return $query;
    }

    public static function get_by_slug($slug)
    {
        $check = $query = Menus::query()->where('slug', $slug);

        if (!$check->first()) {
            abort(404);
        }

        $result = $query->where('status', 'active')->first();
        return $result;
    }

    public static function get_all_except($slug)
    {
        $query = Menus::query()->where('slug', '!=', $slug);
        $result = $query->where('status', 'active')->get();
        return $result;
    }
}
