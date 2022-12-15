<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;
    protected $table = 'sewas';
    protected $fillable = ['kode','nopol','nik','penanggung_jawab','harga','denda','status'];

    public function waktusewa(){
        return $this->belongsTo(WaktuSewa::class, 'sewa_id');
    }
}
