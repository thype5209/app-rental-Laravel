<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;
    protected $table = 'mobils';
    protected $fillable  = ['unit','nopol', 'foto1','foto2','spesifikasi','tahun','foto3','foto4', 'status','harga'];


    public function sewa(){
        return $this->hasMany(Sewa::class,'nopol','nopol');
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('unit', 'like', '%' . $search . '%')
            ->orWhere('nopol', 'like', '%' . $search . '%')
            ->orWhere('spesifikasi', 'like', '%' . $search . '%');
        })->when($filters['status'] ?? null, function ($query, $status) {
            if ($status != '0') {
                $query->orWhere('status', $status);
            } elseif ($status == '0') {
                $query->orderBy('name','asc');
            }
        });
    }
}
