<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymet_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'pd_inst_number',
        'pd_collection_date',
        'pd_amount',
        'pd_recipt',
        'tower_id',
        'floor_id',
        'home_id',
        'cus_id'// Add pd_collection_date to the fillable array
    ];
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
}
