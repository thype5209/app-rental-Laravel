<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use Inertia\Inertia;
use App\Models\Mobil;
use App\Models\Sopir;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSewaRequest;
use App\Http\Requests\UpdateSewaRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class SewaController extends Controller
{

    public function __construct()
    {
        $this->CekSewaTelat();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Inertia::render('Sewa/Pinjam', [
            'sewa' =>  Sewa::orderBy('status','desc')
            ->with(['pengguna', 'waktusewa', 'user'])
            ->when(FacadesRequest::input('status'), function($query,$status){
                if ( $status != 'semua') {
                    $query->orWhere('status', $status);
                    $query->orderBy('status','asc');
                } elseif ($status == 'semua') {
                    $query->orderBy('status','desc');
                }
            })
            ->filter(FacadesRequest::only('search'))
            ->paginate(10) ?? null,
            'Tab' => FacadesRequest::input('status', 'semua'),
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
        $mobil = Mobil::where('status', '!=','2')->get();
        $pengguna = Pengguna::all();
        $sopir = Sopir::all();
        return Inertia::render('Sewa/FormSewa', [
            'pengguna' => $pengguna,
            'mobil' => $mobil,
            'sopir'=> $sopir,
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
            'jenis_sewa'=> 'required',
            'nik' =>  $request->jenis_sewa == "Kunci" ? 'nullable': 'required|numeric',
            'nama' =>  $request->jenis_sewa == "Kunci" ? 'nullable': 'required|string',
            'tempat_lahir' =>  $request->jenis_sewa == "Kunci" ? 'nullable': 'required|string',
            'tgl_lahir' =>  $request->jenis_sewa == "Kunci" ? 'nullable': 'required|date',
            'pekerjaan' =>  $request->jenis_sewa == "Kunci" ? 'nullable': 'required|string',
            'no_hp' =>  $request->jenis_sewa == "Kunci" ? 'nullable': 'required|numeric',
            'no_hp_lain' =>  $request->jenis_sewa == "Kunci" ? 'nullable': 'required|numeric',
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

    public function CekSewaTelat()
    {
        $carbon = Carbon::now()->format("Y-m-d");
        Sewa::whereHas('waktusewa', function($query) use($carbon){
            $query->whereDate('tgl_kembali', '<', $carbon);
        })->whereNot('status', '=', 'Selesai')->update([
            'status'=>"Telat",
        ]);
    }
    /**
     * updateStatusModal
     *  Update Status Dari Modal
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function updateStatusModal($id, Request $request)
    {
        $sewa = Sewa::find($id);
        $sewa->update([
            'status' =>  $request->status,
        ]);
        Mobil::where('nopol', '=', $sewa->nopol)->update([
            'status' => $request->status == 'Selesai' ? '2' : '1',
        ]);
        // Synchronously
    }
}
