<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_number',
        'owner_id',
        'plot_number',
        'survey_number',
        'area_sqft',
        'land_type',
        'location',
        'district',
        'state',
        'latitude',
        'longitude',
        'document_path',
        'status',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function propertyTaxes()
    {
        return $this->hasMany(PropertyTax::class);
    }
}
