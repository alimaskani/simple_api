<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color_id',
        'brand_id',
        'subtitle'
    ];

    public function color(){
        return$this->hasMany(Color::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
