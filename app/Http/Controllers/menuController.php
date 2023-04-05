<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response;
use App\Models\menuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class menuController extends Controller
{
    public function getmenu(){
        $dt_menu=menuModel::get();
        return response()->json($dt_menu);
    }


    public function createmenu(Request $req){
        $validator = Validator::make($req->all(),[
            'nama_menu'=>'required',
            'jenis'=>'required',
            'deskripsi'=>'required',
            'gambar'=>'required|image|mimes:jpeg,png,jpg,gif,svg,jfif',
            'harga'=>'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }

        $imageName = time().'.'.request()->gambar->getClientOriginalExtension();
        request()->gambar->move(public_path('menu_image'),$imageName);

        //$imagepath = $req->file('image')->store('public/images');
        $save = menuModel::create([
            'nama_menu' =>$req->get('nama_menu'),
            'jenis' =>$req->get('jenis'),
            'deskripsi' =>$req->get('deskripsi'),
            'gambar' => $imageName,
            'harga' =>$req->get('harga')

        ]);
        if($save){
            return Response()->json(['status'=>true, 'message'=>'Sukses Menambahkan Menu']);
        }else{
            return Response()->json(['status'=>false, 'message'=>'Gagal Menambahkan Menu']);
        }
    }
    
   
    public function searchmenu(Request $req)
    {
        
        $data=$req->get('katakunci');
        $search_menu = menuModel::where('id_menu', 'like', "%$data%")
                         ->orWhere('nama_menu', 'like', "%$data%")
                         ->orWhere('jenis', 'like', "%$data%")
                         ->orWhere('deskripsi', 'like', "%$data%")
                         ->orWhere('harga', 'like', "%$data%")
                         ->get();

        return Response()->json([
            'data' => $search_menu
        ]);     
    }

    public function updatemenu(Request $req, $id)
    {
        $validator = Validator::make($req->all(),[
            'nama_menu'=>'required',
            'jenis'=>'required',
            'deskripsi'=>'required',
            'gambar'=>'required',
            'harga'=>'required',
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $ubah=menuModel::where('id_menu',$id)->update([
            'nama_menu'=>$req->get('nama_menu'),
            'jenis' =>$req->get('jenis'),
            'deskripsi' =>$req->get('deskripsi'),
            'gambar' =>$req->get('gambar'),
            'harga' =>$req->get('harga'),
        ]);
        if($ubah){
            return Response()->json(['status'=>true, 'message'=>'Sukses Mengubah Menu']);
        }else{
            return Response()->json(['status'=>false, 'message'=>'Gagal Mengubah Menu']);
        }
    }
    public function destroymenu($id){
        $hapus=menuModel::where('id_menu',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>true,'message'=>'Sukses Hapus Menu']);
        }else{
            return Response()->json(['status'=>false,'message'=>'Gagal Hapus Menu']);
        }
    }

    public function getdetailmenu($id){
        $get_detail = menuModel::where('id_menu',$id)->get();
        return response()->json($get_detail);
    }

}
