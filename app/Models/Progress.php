<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;
    protected $fillable = [
        'pr_date',
        'pr_image',
        'pr_remark',
        'tower_id',
        'floor_id',
        'home_id',// Add pd_collection_date to the fillable array
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
}
