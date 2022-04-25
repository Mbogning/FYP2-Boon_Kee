<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $table = "reservations";
    protected $fillable = [
        'customer_id',
        'reservation_date',
        'reservation_time',
        'reservation_status',
        'reservation_total_amount',
        'reservation_total_guest',
        'reservation_remarks'
    ];

    public static function get_records($search)
    {
        $query = Reservation::query();
        $query->where('reservation_status', '!=', 'Deleted');
        $result = $query->paginate(15);
        return $result;
    }

    // ? Get customer reservation history
    public static function reservation_history()
    {
        $customer = auth()->user();
        $query = Reservation::query();
        $query->where('customer_id', $customer->id);
        $result = $query->paginate(10);
        return $result;
    }

    // ? Relations
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Orders::class, 'reservation_id');
    }
}
