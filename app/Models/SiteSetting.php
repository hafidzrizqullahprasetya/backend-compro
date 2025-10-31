<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'company_name',
        'company_logo',
        'hero_title',
        'hero_subtitle',
        'visi_misi_label',
        'visi_misi_title',
        'produk_label',
        'produk_title',
        'clients_label',
        'clients_title',
        'riwayat_label',
        'riwayat_title',
        'testimoni_label',
        'testimoni_title',
        'kontak_label',
        'kontak_title',
    ];

    protected $appends = ['company_logo_url'];

    public function getCompanyLogoUrlAttribute()
    {
        if ($this->company_logo) {
            // Check if it's already a full URL
            if (filter_var($this->company_logo, FILTER_VALIDATE_URL)) {
                return $this->company_logo;
            }
            // Otherwise, return storage URL
            return asset('storage/' . $this->company_logo);
        }
        return null;
    }
}
