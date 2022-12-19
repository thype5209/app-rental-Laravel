<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use Inertia\Inertia;
use App\Models\Mobil;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSewaRequest;
use App\Http\Requests\UpdateSewaRequest;

class SewaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status;
        $sewa = Sewa::with(['pengguna', 'waktusewa'])->get();
        if ($status == 0) {
            $sewa = Sewa::with(['pengguna', 'waktusewa'])->where('status', '0')->get();
        } else if ($status == 1) {
            $sewa = Sewa::with(['pengguna', 'waktusewa'])->where('status', '1')->get();
        }
        return Inertia::render('Sewa/Pinjam', [
            'sewa' => $sewa,
            'Tab' => $request->status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mobil = Mobil::where('status', '2')->get();
        $pengguna = Pengguna::all();
        return Inertia::render('Sewa/FormSewa', [
            'pengguna' => $pengguna,
            'mobil' => $mobil,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSewaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function formulir(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tgl_lahir' => 'required|date',
            'pekerjaan' => 'required|string',
            'no_hp' => 'required|numeric',
            'no_hp_lain' => 'required|numeric',
            'unit' => 'required|string',
            'nopol' => 'required|string',
            'tahun' => 'required|string',
            'nilaisewahari' => 'required|string',
            'nilaisewabulan' => 'required|string',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date',
            'lama_sewa' => 'required|string',
            'tujuan' => 'required|string',
            'jaminan' => 'string',
        ]);
        $dat = $request->all();
        return Inertia::render('Sewa/Formulir', [
            'formulir' => $dat,
        ]);
    }
    public function store(StoreSewaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sewa  $sewa
     * @return \Illuminate\Http\Response
     */
    public function show(Sewa $sewa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sewa  $sewa
     * @return \Illuminate\Http\Response
     */
    public function edit(Sewa $sewa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSewaRequest  $request
     * @param  \App\Models\Sewa  $sewa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSewaRequest $request, Sewa $sewa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sewa  $sewa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sewa $sewa)
    {
        //
    }
    public function StatusUpdate(Sewa $Sewa, $id, Request $request)
    {
        $Sewa->find($id)->update([
            'status' => $request->status,
        ]);
    }

    public function StatusModal()
    {
        return Inertia::dialog('Sewa/status');
    }
    public function updateStatusModal($id, Request $request)
    {
        $sewa = Sewa::find($id);
        $sewa->update([
            'status' =>  $request->status,
        ]);
        Mobil::where('nopol', '=' ,$sewa->nopol)->update([
            'status'=> $request->status == 5 ? '2': '1',
        ]);
        // Synchronously
    }
}
