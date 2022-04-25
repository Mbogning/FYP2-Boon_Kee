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
