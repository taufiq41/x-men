<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class HeroSkillController extends Controller
{
    
    public function store(Request $request,$id)
    {
        $data = $request->only(['skill_id']);
    
        $validator = Validator::make($data,[
            'skill_id' => 'required'
        ]);

        if ($validator->passes()) {
        }

        // return redirect()->route('transaksi.peralihan')->with('success', 'Transaksi Peralihan disimpan');
        return response()->json(['error'=> $validator->errors(),'data' => $data]);
    }

    
    
    public function destroy($id)
    {
        //
    }
}
