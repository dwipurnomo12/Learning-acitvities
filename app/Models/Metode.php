<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metode extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function LearningActivities()
    {
        return $this->hasMany(LearningActiviti::class);
    }
}
