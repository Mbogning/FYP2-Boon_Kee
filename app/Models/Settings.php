<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Settings extends Model
{
    use HasSlug;

    protected $table = "settings";
    protected $fillable = [
        'setting_name',
        'setting_slug',
        'setting_value',
        'setting_status'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('setting_name')
            ->saveSlugsTo('setting_slug');
    }

    public static function get_records()
    {
        $query = Settings::query();
        $result = $query->paginate(15);
        return $result;
    }

    public static function get_setting_by_slug($slug)
    {
        $query = Settings::query();
        $query->where('setting_slug', $slug);
        $result = $query->first();
        return $result;
    }
}
