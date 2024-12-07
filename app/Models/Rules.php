<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stores()
    {
        return $this->belongsTo(Stores::class);
    }
}
