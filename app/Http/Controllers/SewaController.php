<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use Inertia\Inertia;
use App\Models\Mobil;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSewaRequest;
use App\Http\Requests\UpdateSewaRequest;
use Illuminate\Support\Facades\Request as FacadesRequest;

class SewaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Inertia::render('Sewa/Pinjam', [
            'sewa' => $sewa =  Sewa::query()
            ->with(['pengguna', 'waktusewa'])
            ->orderBy('status', 'asc')
            ->filter(FacadesRequest::only('search'))
            ->when(FacadesRequest::input('status','Sewa'), function($query,$status){
                if ( $status != 'semua') {
                    $query->orWhere('status', $status);
                    $query->orderBy('status','asc');
                } elseif ($status == 'semua') {
                    $query->orderBy('status','desc');
                }
            })
            ->paginate(10) ?? Sewa::where('status', '=', 'Sewa')->paginate(10),
            'Tab' => FacadesRequest::input('status', 'Sewa'),
        ]);
    }
    public function riwayat()
    {
        return Inertia::render('Sewa/Riwayat', [
            'sewa' => Sewa::query()
                ->with(['pengguna', 'waktusewa'])
                ->orderBy('status', 'asc')
                ->where('status', 'Selesai')
                ->filter(FacadesRequest::only('search'))
                ->paginate(10),
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
    public function show(Sewa $sewa,$id)
    {
        return Inertia::render('Sewa/Show', [
            'sewa'=> $sewa->with(['pengguna', 'waktusewa'])->find($id)
        ]);
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
    public function destroy(Sewa $sewa,$id)
    {
        $sewa->find($id)->delete();
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
        Mobil::where('nopol', '=', $sewa->nopol)->update([
            'status' => $request->status == 5 ? '2' : '1',
        ]);
        // Synchronously
    }
}
