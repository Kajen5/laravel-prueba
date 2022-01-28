<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    public $timestamps = false;
    protected $fillable = [
        'order_number',
        'date',
        'amount',
        'status',
        'orders_detail_id',
        'user_id'
    ];
    public function orders_detail()
    {
        return $this->hasMany(Orders_Detail::class,'order_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }    
}
