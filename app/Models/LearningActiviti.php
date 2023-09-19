<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningActiviti extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function metode()
    {
        return $this->belongsTo(Metode::class);
    }

    public function bulan()
{
    return $this->belongsTo(Bulan::class);
}
}
