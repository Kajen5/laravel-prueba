<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders_Detail extends Model
{
    use HasFactory;
    protected $table = 'orders__details';
    public $timestamps = false;
    protected $fillable = [
        'item', 
        'quantity',
        'price',
        'total',
        'order_id'
    ];
    public function orders()
    {
        return $this->belongsTo(Orders::class,'order_id');
    }
    public function user()
    {
        return $this->orders->user;
    }
    public function getUserAttribute(){ 
        return $this->orders->user;
      }
}
