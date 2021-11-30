<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hero;

class Skill extends Model
{
    protected $table        = 'skills';
    public $timestamps   =  true;
    
    protected $fillable = [
        'nama'
    ];

    public function joinHero(){
        return $this->belongsToMany(Hero::class);
    }
}