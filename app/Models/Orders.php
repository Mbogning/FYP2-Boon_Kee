<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $fillable = [
        'reservation_id',
        'menu_id',
        'order_quantity',
        'order_price',
    ];

    public static function get_all_order_by_reservation($reservation_id)
    {
        $query = Orders::query();
        $query->where('reservation_id', $reservation_id);
        $result = $query->pluck('menu_id')->toArray();
        return $result;
    }

    public static function get_order_by_reservation_menu($reservation_id, $menu_id)
    {
        $query = Orders::query();
        $query->where('reservation_id', $reservation_id);
        $query->where('menu_id', $menu_id);
        $result = $query->first();
        return $result;
    }

    public static function get_all_orders_by_reservation_id($reservation_id)
    {
        $query = Orders::query();
        $query->where('reservation_id', $reservation_id);
        $result = $query->get();
        return $result;
    }

    // ? Relation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menus::class, 'menu_id');
    }
}
