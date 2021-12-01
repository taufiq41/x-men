<?php

namespace App\Models;

use App\Models\JenisKelamin as ModelsJenisKelamin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $table        = 'heroes';
    public $timestamps      =  true;

    protected $fillable = [
        'nama',
        'jenis_kelamin'
    ];

    public function joinSkill(){
        return $this->belongsToMany(Skill::class,'hero_skill','hero_id','skill_id')->withPivot('id');
    }

    public function joinJenisKelamin(){
        return $this->hasMany(JenisKelamin::class,'jenis_kelamin','jenis_kelamin');
    }
}
