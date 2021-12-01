<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table        = 'skills';
    public $timestamps   =  false;
    
    protected $fillable = ['nama'];

    public function joinHero(){
        return $this->belongsToMany(Hero::class,'hero_skill','skill_id','hero_id')->withPivot('id');
    }
}