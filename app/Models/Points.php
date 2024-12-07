<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function clients()
    {
        return $this->belongsTo(Clients::class);
    }

    public function stores()
    {
        return $this->belongsTo(Stores::class);
    }

    public function transactions()
    {
        return $this->belongsTo(Transactions::class);
    }
}
