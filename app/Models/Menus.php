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
        'img_name'
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

    public static function get_all_menu_img()
    {
        $result = [];
        $menu = Menus::query()->get();

        foreach ($menu as $key => $value) {
            if ($value->img_name) {
                $img = app('firebase.storage')->getBucket()->object('menus/' . $value->slug . '/' . $value->img_name);
                $expiresAt = new \DateTime('tomorrow');
                $result[$value->slug] = $img->signedUrl($expiresAt);
            }
        }

        return $result;
    }

    public static function get_menu_img($slug)
    {
        $result = null;
        $menu = Menus::query()->where('slug', $slug)->first();
        if ($menu->img_name) {
            $img = app('firebase.storage')->getBucket()->object('menus/' . $menu->slug . '/' . $menu->img_name);
            $expiresAt = new \DateTime('tomorrow');
            $result = $img->signedUrl($expiresAt);
        }

        return $result;
    }

    public static function get_menu_by_name($name)
    {
        $result = null;
        $menu = Menus::query();
        $menu->where('name', 'like', '%' . $name . '%');
        $menu->where('status', 'active');
        $result = $menu->get();

        return $result;
    }

    public static function get_menu_by_id_with_img($id)
    {
        $result = null;
        $query = Menus::query();
        $query->where('id', $id);
        $menu = $query->first();
        if ($menu->img_name) {
            $img = app('firebase.storage')->getBucket()->object('menus/' . $menu->slug . '/' . $menu->img_name);
            $expiresAt = new \DateTime('tomorrow');
            $result = $img->signedUrl($expiresAt);
        } else {
            $result = asset('images/NoFoodIMG.png');
        }

        return ['menu' => $menu, 'img' => $result];
    }
}
