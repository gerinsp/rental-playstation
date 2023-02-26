<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function playstation()
    {
        return $this->belongsTo(Playstation::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
