<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ArmorumappTercero extends Model
{
    use HasFactory;

    protected $table = 'armorumapp_terceros';

    public function scopeCurrentUser($query)
    {
        if (Auth::user()->role_id == 2) {
            return $query->where('user_id', Auth::user()->id);
        }
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
