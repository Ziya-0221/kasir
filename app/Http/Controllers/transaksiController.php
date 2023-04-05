<?php

namespace App\Http\Controllers;

use App\Models\detail_transaksiModel;
use App\Models\transaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\DB;

class transaksiController extends Controller
{

    public function gettransaksi(){
        $dt_transaksi=transaksiModel::get();
        return response()->json($dt_transaksi);
    }

    public function updatetransaksi(Request $req, $id)
    {
        $validator = Validator::make($req->all(),[
            'status'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $ubah=transaksiModel::where('id_transaksi',$id)->update([
            'status'=>$req->get('status')
        ]);
        if($ubah){
            return Response()->json(['status'=>true, 'message'=>'Sukses Mengubah Status']);
        }else{
            return Response()->json(['status'=>false, 'message'=>'Gagal Mengubah Status']);
        }
    }


    public function transaksi(Request $request){

        $validasi = Validator::make($request->all(),[
            'id_user' => 'required',
            'nama_pelanggan' => 'required',
            'id_meja' => 'required',
            'total_item' => 'required',
            'status' => 'required',
        ]);
 
        if($validasi->fails()){
            $val = $validasi->errors()->all();
            return $this->erorr($val[0]);
        }

        $tgl_transaksi = now()->format(format: 'Y-m-d');

        $dataTransaksi = array_merge($request->all(),[
             'tgl_transaksi' => $tgl_transaksi,
        ]);

        DB::beginTransaction();
        $checkout = transaksiModel::create($dataTransaksi);
        foreach($request->transaksi as $transaksi){
            $detail = [
                'id_transaksi' => $checkout->id,
                'id_menu' => $transaksi['id_menu'],
                'total_item' => $transaksi['total_item'],
                'harga' => $transaksi['harga'],

            ];

            $detailTransaksi = detail_transaksiModel::create($detail);
        }

        if (!empty($checkout) && !empty($detailTransaksi)){
            DB::commit();
            return response()->json([
                'succes' => 1,
                'message' => 'Transaksi Berhasil',
                'user' => collect($checkout)
            ]);
        }else{
            DB::rollBack();
            $this->error('Transaksi gagal');
        }
    }


    public function searchtransaksi(Request $req)
    {
        
        $data=$req->get('katakunci');
        $search_menu = transaksiModel::where('id_transaksi', 'like', "%$data%")
                         ->orWhere('id_user', 'like', "%$data%")
                         ->orWhere('tgl_transaksi', 'like', "%$data%")
                         ->get();

        return Response()->json([
            'data' => $search_menu
        ]);     
    }
    public function error($pasan){
        return response()->json([
            'succes' => 0,
            'message' => $pasan,
        ]);
    }
}
