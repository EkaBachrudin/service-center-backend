<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function counter()
    {
        return $this->belongsTo(Counter::class, "counters_id");
    }

    public function status()
    {
        return $this->belongsTo(StatusQueue::class, "status_queues_id");
    }
}
