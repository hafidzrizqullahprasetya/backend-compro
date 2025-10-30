<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'background',
        'location',
        'title',
        'machines',
        'clients',
        'customers',
        'experience_years',
        'trust_years',
    ];

    protected $appends = ['background_url'];

    public function getBackgroundUrlAttribute()
    {
        if ($this->background) {
            // If it's already a full URL (http/https), return as is
            if (filter_var($this->background, FILTER_VALIDATE_URL)) {
                return $this->background;
            }
            // Otherwise, return storage URL
            return asset('storage/' . $this->background);
        }
        return null;
    }
}
