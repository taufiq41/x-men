<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSkill extends Model
{
    protected $table = 'hero_skill';
    public $timestamps = false;


    protected $fillable = [
        'hero_id',
        'skill_id'
    ];

    
}
