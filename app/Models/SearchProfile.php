<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class SearchProfile extends Model
{
    use HasFactory;
    use Uuids;
    protected $casts = [
        'search_fields' => 'array',
    ];

    protected $fillable = ["name", "search_fields"];
}
