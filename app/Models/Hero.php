<?php

namespace App\Models;

use App\Models\JenisKelamin as ModelsJenisKelamin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Skill;
use JenisKelamin;
class Hero extends Model
{
    protected $table        = 'heroes';
    public $timestamps   =  true;

    protected $fillable = [
        'nama',
        'jenis_kelamin'
    ];

    public function joinSkill(){
        return $this->belongsToMany(Skill::class);
    }

    public function joinJenisKelamin(){
        return $this->hasMany(JenisKelamin::class,'jenis_kelamin','jenis_kelamin');
    }
}
