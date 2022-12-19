<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;
    protected $table = 'sewas';
    protected $fillable = ['jenis_sewa','kode','nopol','unit','tahun','nik','tujuan','jaminan','penanggung_jawab','harga','denda','status','harga_bulan','pdf_url'];

    public function waktusewa(){
        return $this->hasOne(WaktuSewa::class, 'sewa_id','id');
    }
    public function pengguna(){
        return $this->hasOne(Pengguna::class,'nik','nik');
    }
}
