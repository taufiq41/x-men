<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Skill;

class HeroSkill extends Model
{
    protected $table = 'hero_skill';
    public $timestamps = false;


    protected $fillable = [
        'hero_id',
        'skill_id'
    ];

    public function joinSkill(){
        return $this->belongsTo(Skill::class,'skill_id','id');
    }
}
