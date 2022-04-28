<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Property extends Model
{
    use HasFactory;
    use Uuids;


    protected $fillable = ["name", "address", "fields"];

    protected $casts = [
        'fields' => 'array',
    ];

    public function propertyType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }
}
