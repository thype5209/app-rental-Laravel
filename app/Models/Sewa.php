<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;
    protected $table = 'sewas';
    protected $fillable = ['jenis_sewa', 'kode', 'nopol', 'unit', 'tahun', 'nik', 'tujuan', 'jaminan', 'penanggung_jawab', 'harga', 'denda', 'status', 'harga_bulan', 'pdf_url'];

    public function waktusewa()
    {
        return $this->hasOne(WaktuSewa::class, 'sewa_id', 'id');
    }
    public function pengguna()
    {
        return $this->hasOne(Pengguna::class, 'nik', 'nik');
    }
    public function user(){
        return $this->hasOne(User::class, 'id', 'penanggung_jawab');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nik', 'like', '%' . $search . '%')
                ->orWhere('kode', 'like', '%' . $search . '%')
                ->orWhere('tahun', 'like', '%' . $search . '%')
                ->orWhere('harga_bulan', 'like', '%' . $search . '%')
                ->orWhere('harga', 'like', '%' . $search . '%')
                ->orWhere('penanggung_jawab', 'like', '%' . $search . '%')
                ->orWhere('tujuan', 'like', '%' . $search . '%')
                ->orWhere('jaminan', 'like', '%' . $search . '%')
                ->orWhere('nopol', 'like', '%' . $search . '%')
                ->orWhereHas('waktusewa', function ($query) use ($search) {
                    $query->whereDate('tgl_sewa', 'like', '%' . $search . '%')
                        ->orWhereDate('tgl_kembali', 'like', '%' . $search . '%')
                        ->orWhere('lama_sewa', 'like', '%' . $search . '%');
                })
                ->orWhereHas('pengguna', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%')
                        ->orWhere('pekerjaan', 'like', '%' . $search . '%')
                        ->orWhere('no_hp', 'like', '%' . $search . '%');
                });
        })->when($filters['status'] ?? null, function ($query, $status) {
            if ( $status != 'semua') {
                $query->orWhere('status', $status);
            } elseif ($status == 'semua') {
                $query->orderBy('status','desc');
            }
        });
    }
}
