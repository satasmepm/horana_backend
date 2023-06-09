<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floors extends Model
{
    use HasFactory;
    public function tower() {
        return $this->hasOne( Towers::class, 'id', 'tower_id' );
    }
}
