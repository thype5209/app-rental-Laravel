<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaktuSewa extends Model
{
    use HasFactory;
    protected $table ='waktu_sewas';
    protected $fillable = ['sewa_id','tgl_sewa','jam_sewa','tgl_kembali','jam_kembali','lama_sewa'];

    public function sewa(){
        return $this->hasOne(Sewa::class, 'id','sewa_id');
    }

}
