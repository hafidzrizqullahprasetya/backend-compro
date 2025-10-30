<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyHistory extends Model
{
    protected $fillable = [
        'tahun',
        'judul',
        'deskripsi',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];
}
