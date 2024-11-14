<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'subtotal'];

    protected $casts = [
        'quantity' => 'integer',
        'subtotal' => 'float',
    ];

    public function save(array $options = [])
    {
        $exists = OrderItem::where('order_id', $this->order_id)
            ->where('product_id', $this->product_id)
            ->exists();

        if ($exists) {
            throw new \Exception('Duplicate product in the same order');
        }

        parent::save($options);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
