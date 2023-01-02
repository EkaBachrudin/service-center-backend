<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function queues()
    {
        return $this->hasMany(Episode::class, "counters_id");
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_counters');
    }

    public function status()
    {
        return $this->belongsTo(StatusCounter::class, "setatus_counters_id");
    }
}
