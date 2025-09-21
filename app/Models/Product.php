<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function client()
    {
        return $this->belongsTo(OurClient::class, 'client_id');
    }   
}
