<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\Skill;
use App\Models\HeroSkill;
use Validator;

class CombinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hero_laki_laki = Hero::where('jenis_kelamin','L')->get();
        $hero_perempuan = Hero::where('jenis_kelamin','P')->get();

        return view('combination.index',compact('hero_laki_laki','hero_perempuan'));
    }

    public function datatable(Request $request){

        $data = $request->only(['hero_id_laki_laki','hero_id_perempuan']);

        $validator = Validator::make($data,[
            'hero_id_laki_laki' => 'required',
            'hero_id_perempuan' => 'required'
        ]);

        if ($validator->passes()) {

            $hero_id_laki_laki = $data['hero_id_laki_laki'];
            $hero_id_perempuan = $data['hero_id_perempuan'];

            // $search_all = $request->input('search')['value'];
        
            $result = HeroSkill::with(['joinSkill'])->where(function($query) use($hero_id_laki_laki,$hero_id_perempuan){
                $query->where('hero_skill.hero_id',$hero_id_laki_laki);
                $query->orWhere('hero_skill.hero_id',$hero_id_perempuan);
            });


            $result_all = $result;
            $length = $request->input('length');
            $start = $request->input('start');
        
            if($length != -1){
                $result = $result->groupBy('hero_skill.skill_id')->skip($start)->take($length)->get();
            }else{
                $result = $result->groupBy('hero_skill.skill_id')->get();
            }

            $data = $result;

            if($request->input('draw') != null){
                $draw = $request->input('draw');
            }else{
                $draw = null;
            }

            $recordsTotal = $result_all->count();

            $response = [
                "post" => $request->all(),
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsTotal,
                "data" => $data
            ];
            return response()->json($response);
        }

        return response()->json(['error'=> $validator->errors()]);

    }

    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
      
    }

   
    public function update(Request $request, $id)
    {
        
    }

    
    public function destroy($id)
    {
        
    }
}
