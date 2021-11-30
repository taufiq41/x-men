<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\JenisKelamin;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis_kelamin = JenisKelamin::all();
        return view('hero.index', compact('jenis_kelamin'));
    }

    
    public function create()
    {
        
    }

    public function datatable(Request $request){
        
        $search_all = $request->input('search')['value'];
        
        $result = Hero::select('heroes.id','heroes.nama','jenis_kelamin.nama AS jenis_kelamin_nama')->joinJenisKelamin();

        if($search_all != null && $search_all != ""){
            $result = $result->where(function($query) use($search_all){
                    $query->orWhere('heroes.nama','like','%'.$search_all.'%');
                    $query->orWhere('jenis_kelamin.nama','like','%'.$search_all.'%');
                    
            });
        }

        $result_all = $result;
        
        $length = $request->input('length');
        $start = $request->input('start');
        
        $query = $result->skip($start)->take($length)->toSql();

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
            "query" => $query,
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
        $data = $request->only(['nama','jenis_kelamin']);

        $validator = Validator::make($data,[
            'nama' => 'required',
            'jenis_kelamin' => 'required'
        ]);

        if ($validator->passes()) {

            $insert = Hero::create($data);
            if($insert){
                return response()->json(['result' => true, 'keterangan' => 'Hero baru berhasil di Simpan']);
            }else{
                return response()->json(['result' => false, 'keterangan' => 'Hero baru gagal di Simpan']);
            }
        }

        return response()->json(['error'=> $validator->errors(),'data' => $data]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Hero::find($id);
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
