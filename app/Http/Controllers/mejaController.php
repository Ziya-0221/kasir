<?php

namespace App\Http\Controllers;

use App\Models\mejaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class mejaController extends Controller
{
    public function getmeja(){
        $dt_meja=mejaModel::get();
        return response()->json($dt_meja);
    }

    public function createmeja(Request $req){
        $validator = Validator::make($req->all(),[
            'nomor_meja'=>'required',
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $save = mejaModel::create([
            'nomor_meja' =>$req->get('nomor_meja'),
        ]);
        if($save){
            return Response()->json(['status'=>true, 'message'=>'Sukses Menambahkan Meja']);
        }else{
            return Response()->json(['status'=>false, 'message'=>'Gagal Menambahkan Meja']);
        }
    }

    public function updatemeja(Request $req, $id)
    {
        $validator = Validator::make($req->all(),[
            'nomor_meja'=>'required',
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $ubah=mejaModel::where('id_meja',$id)->update([
            'nomor_meja'=>$req->get('nomor_meja'),
        ]);
        if($ubah){
            return Response()->json(['status'=>true, 'message'=>'Sukses Mengubah Meja']);
        }else{
            return Response()->json(['status'=>false, 'message'=>'Gagal Mengubah Meja']);
        }
    }
    public function destroymeja($id){
        $hapus=mejaModel::where('id_meja',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>true,'message'=>'Sukses Hapus Meja']);
        }else{
            return Response()->json(['status'=>false,'message'=>'Gagal Hapus Meja']);
        }
    }

    public function getdetailmeja($id){
        $get_detail = mejaModel::where('id_meja',$id)->get();
        return response()->json($get_detail);
    }

}
