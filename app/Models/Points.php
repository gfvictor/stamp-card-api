<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function clients(): Relation
    {
        return $this->hasMany(Client::class, 'clients_id');
    }

    public function stores(): Relation
    {

    }
}
