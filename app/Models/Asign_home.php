<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asign_home extends Model
{
    use HasFactory;
    public function tower() {
        return $this->hasOne( Towers::class, 'id', 'tower_id' );
    }
    public function floor() {
        return $this->hasOne( Floors::class, 'id', 'floor_id' );
    }
    public function home() {
        return $this->hasOne( Homes::class, 'id', 'home_id' );
    }
    public function customer() {
        return $this->hasOne( Customers::class, 'id', 'cus_id' );
    }
    public function types() {
        return $this->hasOne( PaymentStatus::class, 'id', 'ah_type' );
    }
}
