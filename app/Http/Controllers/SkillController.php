<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\Hero;
use Validator;
class SkillController extends Controller
{ 
    public function index()
    {
        return view('skill.index');
    }

    
    public function create()
    {
        
    }

    public function datatable(Request $request){
        
        $search_all = $request->input('search')['value'];
        
        
                   
        if($search_all != null && $search_all != ""){
            $result = SKill::where('skills.nama','like','%'.$search_all.'%');
        }else{
            $result = Skill::where('skills.nama','like','%%');
        }

        $result_all = $result;
        
        $length = $request->input('length');
        $start = $request->input('start');

        if($length != -1){
            $result = $result->skip($start)->take($length)->get();
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

    public function store(Request $request)
    {  
        $data = $request->only(['nama']);

        $validator = Validator::make($data,[
            'nama' => 'required'
        ]);

        if ($validator->passes()) {

            $insert = Skill::create($data);
            if($insert){
                return response()->json(['result' => true, 'keterangan' => 'Skill baru berhasil di Simpan']);
            }else{
                return response()->json(['result' => false, 'keterangan' => 'Skill baru gagal di Simpan']);
            }
        }

        return response()->json(['error'=> $validator->errors(),'data' => $data]);
        
    }

    
    public function show($id)
    {
        $skill = Skill::find($id);
        $hero = Hero::all();

        return view('skill.view',compact('skill','hero'));
    }

    
    public function edit($id)
    {
        $result = Skill::find($id);
        return response()->json($result);
    }

    
    public function update(Request $request, $id)
    {
        $data = $request->only(['nama']);

        $validator = Validator::make($data,[
            'nama' => 'required'
        ]);
        
        if ($validator->passes()) {

            $update = Skill::where('id',$id)->update($data);
            if($update){
                return redirect()->route('skill.show',['id' => $id])->with('success', 'Berhasil update data skill');
            }else{
                return redirect()->route('skill.show',['id' => $id])->with('failure', 'Gagal update data skill');
            }
        }

        return redirect()->route('skill.show',['id' => $id])->withInput()->withErrors($validator);
    }

    public function destroy($id)
    {
        // forceDelete
        $delete = Skill::where('id', $id)->delete();
        if($delete){
           $response = ['result' => true, 'keterangan' => 'Skill berhasil di hapus']; 
        }else{
            $response = ['result' => false,'keterangan' => 'Skill gagal di hapus'];
        }

        return response()->json($response);
    }

}
