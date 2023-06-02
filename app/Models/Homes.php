<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homes extends Model
{
    use HasFactory;
    public function tower() {
        return $this->hasOne( Towers::class, 'id', 'tower_id' );
    }
    public function floor() {
        return $this->hasOne( Floors::class, 'id', 'floor_id' );
    }
}
