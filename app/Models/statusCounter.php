<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusCounter extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function counters()
    {
        return $this->hasMany(Counter::class, "setatus_counters_id");
    }
}
