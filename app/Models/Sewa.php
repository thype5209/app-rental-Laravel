<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sewa extends Model
{
    use HasFactory;
    use SoftDeletes;
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
    public function user()
    {
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
                ->orWhere('status', 'like', '%' . $search . '%')
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
            if ($status != 'semua') {
                $query->orWhere('status', $status);
            } elseif ($status == 'semua') {
                $query->orderBy('status', 'desc');
            }
        })->when(function ($query) {
            // foreach (Auth::user()->role as $role) {
            if (Auth::user()->role == 'writer') {
                $query->where('penanggung_jawab', '=', Auth::user()->id);
            }
            // }
        });
    }
    public function scopeDateFilter($query, array $date)
    {
        $query->when($date ?? null, function($query) use ($date){
            $query->whereHas('waktusewa', function ($query) use ($date) {
                $query->whereBetween('created_at', [$date['min'], $date['max']]);
            });
        });
    }
}
