<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class PropertyType extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable  = ["type"];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function searchProfiles()
    {
        return $this->hasMany(SearchProfile::class);
    }
}
