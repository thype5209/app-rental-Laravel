<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetPengguna()
    {
        $pengguna = Pengguna::all();
        return response()->json($pengguna);
    }
    public function index()
    {
        return Inertia::render('Pengguna/Pengguna', [
            'pengguna' => Pengguna::query()->with(['sewa', 'sewa.waktusewa'])->when(Request::input('search'), function ($query, $search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%')
                    ->orWhere('no_hp_lain', 'like', '%' . $search . '%')
                    ->orWhere('tempat_lahir', 'like', '%' . $search . '%')
                    ->orWhere('tgl_lahir', 'like', '%' . $search . '%');
            })->orderBy('nama', 'asc')->paginate(10) ?? null,
            'filter' => Request::input('search', ''),
            'can'=>[
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ],
        ]);
    }
    public function cariNIK()
    {
        $pengguna = Pengguna::where('nik', 'like', '%' .  Request::input('search') . '%')
        ->orWhere('nama', 'like', '%' .  Request::input('search') . '%')
        ->get();
        return json_encode($pengguna);
    }
    public function GetID($id)
    {
        $pengguna = Pengguna::with('sewa', 'sewa.waktusewa')->whereHas('sewa', function ($query) {
            $query->whereIn('status_bayar', ['2', '3', '4']);
        })
            ->where('id', $id)
            ->get();
        if ($pengguna->count() > 0) {
            $resp = Pengguna::with('sewa', 'sewa.waktusewa')->whereHas('sewa', function ($query) {
                $query->whereIn('status_bayar', ['2', '3', '4']);
            })->find($id);
            $code = true;
        } else {
            $resp = Pengguna::with('sewa', 'sewa.waktusewa')->find($id);
            $code = false;
        }
        $data = [
            'query' => $resp,
            'status' => $code,
        ];
        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Pengguna/Form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Request::validate([
            'nik'=> 'numeric|required',
            'nama'=> 'required|string',
            'no_hp'=> 'string|required',
            'no_hp_lain'=> 'string|required',
            'alamat'=> 'string|required',
            'pekerjaan'=> 'string|required',
            'tempat_lahir'=> 'string|required',
            'tgl_lahir'=> 'required|date',
        ]);
        $image = null;
        if(Request::file('foto_ktp') != null){
            $image = Request::input('nik'). '.' . Request::file('foto_ktp')->getClientOriginalName();
            Request::file('foto_ktp')->getClientOriginalName();
            Request::file('foto_ktp')->storeAs('public/FotoKTP', $image);
        }
        Pengguna::create([
            'foto_ktp'=> $image,
            'nik'=> Request::input('nik'),
            'nama'=> Request::input('nama'),
            'no_hp'=> Request::input('no_hp'),
            'no_hp_lain'=> Request::input('no_hp_lain'),
            'alamat'=> Request::input('alamat'),
            'pekerjaan'=> Request::input('pekerjaan'),
            'tempat_lahir'=> Request::input('tempat_lahir'),
            'tgl_lahir'=> Request::input('tgl_lahir'),
        ]);
        return Redirect::route('Pengguna.index')->with('success',' Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function show(Pengguna $pengguna, $id)
    {
        // dd(Pengguna::find($id));
        return Inertia::render('Pengguna/RiwayatPengguna', [
            'riwayat' => $pengguna->with(['sewa', 'sewa.waktusewa'])->find($id),
            'pengguna' => Pengguna::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengguna $pengguna, $id)
    {
        return Inertia::render('Pengguna/Edit', [
            'pengguna'=> $pengguna->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengguna $pengguna,$id)
    {
        Request::validate([
            'nik'=> 'numeric|required',
            'nama'=> 'required|string',
            'no_hp'=> 'string|required',
            'no_hp_lain'=> 'string|required',
            'alamat'=> 'string|required',
            'pekerjaan'=> 'string|required',
            'tempat_lahir'=> 'string|required',
            'tgl_lahir'=> 'required|date',
        ]);
        $data = $pengguna->find($id);
        $image = $data->foto_ktp;
        if(Request::input('foto_ktp') != null){
            $image = Request::input('nik'). '.' . Request::file('foto_ktp')->getClientOriginalName();
            Request::file('foto_ktp')->getClientOriginalName();
            Request::file('foto_ktp')->storeAs('public/FotoKTP', $image);
        }
        $pengguna->find($id)->update([
            'foto_ktp'=> $image,
            'nik'=> Request::input('nik'),
            'nama'=> Request::input('nama'),
            'no_hp'=> Request::input('no_hp'),
            'no_hp_lain'=> Request::input('no_hp_lain'),
            'alamat'=> Request::input('alamat'),
            'pekerjaan'=> Request::input('pekerjaan'),
            'tempat_lahir'=> Request::input('tempat_lahir'),
            'tgl_lahir'=> Request::input('tgl_lahir'),
        ]);
        return Redirect::route('Pengguna.index')->with('success',' Berhasil Di Edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengguna $pengguna, $id)
    {
        $pengguna->find($id)->delete();
    }
}
