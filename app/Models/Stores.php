<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Stores extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rules(): Relation
    {
        return $this->hasMany(Rule::class, 'rules_id');
    }

    public function transactions(): Relation
    {
        return $this->hasMany(Transaction::class, 'transactions_id');
    }

    public function points(): Relation
    {
        return $this->hasMany(Point::class, 'points_id');
    }
}
