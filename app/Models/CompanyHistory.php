<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyHistory extends Model
{
    protected $fillable = [
        'tahun',
        'judul',
        'deskripsi',
        'image_path',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            // Check if it's already a full URL
            if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
                return $this->image_path;
            }
            // Otherwise, return storage URL
            return asset('storage/' . $this->image_path);
        }
        return null;
    }
}
