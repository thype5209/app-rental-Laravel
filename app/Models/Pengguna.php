<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    protected $table = 'penggunas';
    protected $fillable = ['foto_ktp','nik','nama','alamat','no_hp','no_hp_lain','pekerjaan','tempat_lahir','tgl_lahir'];

    public function sewa()
    {
        return $this->hasMany(Sewa::class, 'nik','nik');
    }
}
