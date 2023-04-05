<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function getuser(){
        $dt_user=User::get();
        return response()->json($dt_user);
    }

    public function createuser(Request $req){
        $validator = Validator::make($req->all(),[
            'nama_user'=>'required',
            'role'=>'required',
            'username'=>'required',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $save = User::create([
            'nama_user' =>$req->get('nama_user'),
            'role' =>$req->get('role'),
            'username' =>$req->get('username'),
            'password' => Hash::make($req->get('password'))
        ]);
        if($save){
            return Response()->json(['status'=>true, 'message'=>'Sukses Menambahkan user']);
        }else{
            return Response()->json(['status'=>false, 'message'=>'Gagal Menambahkan user']);
        }
    }


    public function searchuser(Request $req)
    {
        
        $data=$req->get('katakunci');
        $search_menu = User::where('id_user', 'like', "%$data%")
                         ->orWhere('nama_user', 'like', "%$data%")
                         ->orWhere('role', 'like', "%$data%")
                         ->orWhere('username', 'like', "%$data%")
                         ->get();

        return Response()->json([
            'data' => $search_menu
        ]);     
    }
    public function updateuser(Request $req, $id)
    {
        $validator = Validator::make($req->all(),[
            'nama_user'=>'required',
            'role'=>'required',
            'username'=>'required',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $ubah=User::where('id_user',$id)->update([
            'nama_user'=>$req->get('nama_user'),
            'role' =>$req->get('role'),
            'username' =>$req->get('username'),
            'password' =>$req->get('password')
        ]);
        if($ubah){
            return Response()->json(['status'=>true, 'message'=>'Sukses Mengubah user']);
        }else{
            return Response()->json(['status'=>false, 'message'=>'Gagal Mengubah user']);
        }
    }
    public function destroyuser($id){
        $hapus=User::where('id_user',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>true,'message'=>'Sukses Hapus user']);
        }else{
            return Response()->json(['status'=>false,'message'=>'Gagal Hapus user']);
        }
    }

    public function getdetailuser($id){
        $get_detail = User::where('id_user',$id)->get();
        return response()->json($get_detail);
    }

}
