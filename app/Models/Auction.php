<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = ['title', 'description'];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
