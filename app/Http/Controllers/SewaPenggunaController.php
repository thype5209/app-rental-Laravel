<?php

namespace App\Http\Controllers;

use App\Models\SewaPengguna;
use Illuminate\Http\Request;

class SewaPenggunaController extends Controller
{
    public function createPenggunaSewa($request, $id)
    {
        $pengguna = SewaPengguna::where('nik', $request->nik)->get();
        $nama_ktp = null;
        if ($request->foto_ktp != null) {
            $nama_ktp = $request->nik . '.' .  $request->foto_ktp->getClientOriginalName();
            $request->file('foto_ktp')->storeAs('public/FotoKTP', $nama_ktp);
        }
        SewaPengguna::create([
            'sewa_id' => $id,
            'foto_ktp' => $nama_ktp,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'no_hp_lain' => $request->no_hp_lain,
            'pekerjaan' => $request->pekerjaan,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
        ]);
    }
}
