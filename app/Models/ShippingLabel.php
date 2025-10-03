<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingLabel extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'provider',
        'tracking_code',
        'label_url',
        'status',
        'service_name',
        'estimated_delivery_date',
        'shipping_cost',
        'error_message',
        'shipped_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'estimated_delivery_date' => 'date',
            'shipping_cost' => 'decimal:2',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
