<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
    use HasFactory;
    protected $table = 'sellers';

    protected $fillable = ['name', 'email', 'phone', 'password', 'status'];
    protected $hidden = ['password', 'remember_token'];

    protected function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }
}
