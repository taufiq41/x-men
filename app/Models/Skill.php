<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hero;

class Skill extends Model
{
    protected $table        = 'skills';
    protected $timestamps   =  true;

    public function joinHero(){
        return $this->belongsToMany(Hero::class);
    }
}