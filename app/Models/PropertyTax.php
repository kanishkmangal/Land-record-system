<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyTax extends Model
{
    use HasFactory;

    protected $fillable = [
        'land_record_id',
        'financial_year',
        'base_amount',
        'penalty_amount',
        'total_amount',
        'due_date',
        'status',
    ];

    public function landRecord(): BelongsTo
    {
        return $this->belongsTo(LandRecord::class);
    }
}
