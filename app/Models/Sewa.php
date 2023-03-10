<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sewa extends Model
{
    use HasFactory;
    protected $table = 'sewas';
    protected $fillable = ['jenis_sewa', 'kode', 'nopol', 'unit', 'sopir_id', 'tahun', 'nik', 'tujuan', 'jaminan', 'penanggung_jawab', 'harga', 'denda', 'status', 'pdf_url', 'sisa', 'panjar', 'total', 'status_bayar', 'list_pengiriman', 'metode_bayar', 'ket_syarat','nilai_denda'];

    public function waktusewa()
    {
        return $this->hasOne(WaktuSewa::class, 'sewa_id', 'id');
    }
    public function pengguna()
    {
        return $this->hasOne(Pengguna::class, 'nik', 'nik');
    }
    public function sewapengguna()
    {
        return $this->hasOne(SewaPengguna::class, 'nik', 'nik');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'penanggung_jawab');
    }
    public function mobil()
    {
        return $this->hasOne(Mobil::class, 'nopol', 'nopol');
    }
    public function sopir()
    {
        return $this->hasOne(Sopir::class, 'id', 'sopir_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nik', 'like', '%' . $search . '%')
                ->orWhere('kode', 'like', '%' . $search . '%')
                ->orWhere('tahun', 'like', '%' . $search . '%')
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
                })
                ->orderBy('kode', 'desc');
        })->when($filters['status'] ?? null, function ($query, $status) {
            if ($status != 'semua') {
                $query->orWhere('status', $status);
            } elseif ($status == 'semua') {
                $query->orderBy('kode', 'desc');
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
        $query->when($date ?? null, function ($query) use ($date) {
            if ($date['min'] == null || $date['max'] == null) {
                $query->orderBy('id', 'asc')
                    ->where('status', '=', 'selesai');
            } else {
                $query->whereHas('waktusewa', function ($query) use ($date) {
                    $query->whereBetween('tgl_kembali', [$date['min'], $date['max']]);
                });
            }
        });
    }
    public function scopeStatusBayar($query, $statusBayar)
    {
        $query->when($statusBayar ?? null, function ($query) use ($statusBayar) {
            if ($statusBayar == 'semua') {
                $query->orderBy('status_bayar', 'desc');
            } else {
                $query->where('status_bayar', '=', $statusBayar);
            }
        });
    }
}
