<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\HeroSkill;

class HeroSkillController extends Controller
{
    
    public function store_skill(Request $request,$id)
    {
        $data = $request->only(['skill_id']);
    
        $validator = Validator::make($data,[
            'skill_id' => 'required'
        ]);

        $data['hero_id'] = $id;

        if ($validator->passes()) {
            
            $cek = HeroSkill::where('hero_id',$id)->where('skill_id',$data['skill_id'])->get();
            if(count($cek) == 0){

                $insert = HeroSkill::create($data);
                if($insert){
                    return redirect()->route('hero.show',['id' => $id])->with('success', 'Skill berhasil di tambah');
                }else{
                    return redirect()->route('hero.show',['id' => $id])->with('failure', 'Skill gagal di tambah');
                }

            }else{
                return redirect()->route('hero.show',['id' => $id])->with('failure', 'Skill sudah di tambahkan');
            }
            
        }

        return redirect()->route('hero.show',['id' => $id])->withInput()->withErrors($validator);
    }

    
    public function store_hero(Request $request,$id)
    {
        $data = $request->only(['hero_id']);
    
        $validator = Validator::make($data,[
            'hero_id' => 'required'
        ]);

        $data['skill_id'] = $id;

        if ($validator->passes()) {
            
            $cek = HeroSkill::where('hero_id',$id)->where('skill_id',$data['skill_id'])->get();
            if(count($cek) == 0){

                $insert = HeroSkill::create($data);
                if($insert){
                    return redirect()->route('skill.show',['id' => $id])->with('success', 'Hero berhasil di tambah');
                }else{
                    return redirect()->route('skill.show',['id' => $id])->with('failure', 'Hero gagal di tambah');
                }
                
            }else{
                return redirect()->route('skill.show',['id' => $id])->with('failure', 'Hero sudah di tambahkan');
            }
            
        }

        return redirect()->route('skill.show',['id' => $id])->withInput()->withErrors($validator);
    }

    public function destroy_skill($id,$hero_id)
    {
        $delete = HeroSkill::where('id', $id)->delete();
        if($delete){
            return redirect()->route('hero.show',['id' => $hero_id])->with('success', 'Skill berhasil di hapus');
        }else{
            return redirect()->route('hero.show',['id' => $hero_id])->with('failure', 'Skill gagal di hapus');
        }

    }

    public function destroy_hero($id,$skill_id)
    {
        $delete = HeroSkill::where('id', $id)->delete();
        if($delete){
            return redirect()->route('skill.show',['id' => $skill_id])->with('success', 'Hero berhasil di hapus');
        }else{
            return redirect()->route('skill.show',['id' => $skill_id])->with('failure', 'Hero gagal di hapus');
        }

    }
}
