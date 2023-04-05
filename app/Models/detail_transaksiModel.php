<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_transaksiModel extends Model
{
    use HasFactory;
    protected $table = 'detail_tranksaksi';
    protected $primarykey = 'id_detail_transaksi';
    public $timestamps = false;
    public $fillable = [
        'id_transaksi','id_menu','harga','total_item'
    ];
}
