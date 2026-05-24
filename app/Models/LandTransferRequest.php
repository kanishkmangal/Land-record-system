<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandTransferRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'land_record_id',
        'from_owner_id',
        'to_owner_id',
        'transfer_date',
        'status',
        'remarks',
        'document_path',
        'approved_by',
    ];

    public function landRecord(): BelongsTo
    {
        return $this->belongsTo(LandRecord::class);
    }

    public function fromOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_owner_id');
    }

    public function toOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_owner_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
