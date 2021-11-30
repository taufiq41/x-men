<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hero;

class JenisKelamin extends Model
{
    protected $table        = 'jenis_kelamin';
    public $timestamps   =  false;

    protected $fillable = [
        'jenis_kelamin',
        'nama'
    ];

    public function joinHero(){
        return $this->belongsTo(Hero::class,'jenis_kelamin','jenis_kelamin');
    }
}
