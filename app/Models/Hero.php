<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Skill;

class Hero extends Model
{

    protected $table        = 'heroes';
    protected $timestamps   =  true;


    public function joinSkill(){
        return $this->belongsToMany(Skill::class);
    }

}
