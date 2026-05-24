<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_tax_id',
        'citizen_id',
        'amount_paid',
        'payment_method',
        'transaction_id',
        'payment_date',
        'receipt_number',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function propertyTax(): BelongsTo
    {
        return $this->belongsTo(PropertyTax::class);
    }

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'citizen_id');
    }
}
