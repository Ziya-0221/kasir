<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksiModel extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $primarykey = 'id_transaksi';
    public $timestamps = false;
    public $fillable = [
        'tgl_transaksi','id_user','id_meja','nama_pelanggan','status','total_item'
    ];

    public function details(){
        return $this->hasMany(detail_transaksiModel::class, foreignKey:"id_transaksi", localKey:"id_transaksi");
    }

    // public function user(){
    //     return $this->belongsTo(User::class, foreignKey:"id_user", localKey:"id_user");
    // }
}
