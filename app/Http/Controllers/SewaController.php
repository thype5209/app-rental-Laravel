<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sewa;
use Inertia\Inertia;
use App\Models\Mobil;
use App\Models\Sopir;
use App\Models\Pengguna;
use App\Models\WaktuSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSewaRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateSewaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use ZipArchive;

class SewaController extends Controller
{

    public function __construct()
    {
        $this->CekSewaTelat();
        $this->CekTotal();
        // $this->generateKodeASC();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Sewa/Pinjam', [
            'sewa' =>  Sewa::with(['pengguna', 'waktusewa', 'user'])
                ->when(FacadesRequest::input('status') ?? null, function ($query, $status) {
                    if ($status != 'semua') {
                        $query->orWhere('status', $status);
                        $query->orderBy('status', 'desc');
                    } elseif ($status == 'semua') {
                        $query->orderBy('id', 'desc');
                    }
                })
                ->filter(FacadesRequest::only('search'))
                ->where('status', '!=', 'Selesai')
                ->orderBy('id', 'desc')
                ->paginate(20) ?? null,
            'can' => [
                'create' => Auth::user()->can('sewa create'),
                'edit' => Auth::user()->can('sewa edit'),
                'delete' => Auth::user()->can('sewa delete'),
                'update' => Auth::user()->can('sewa update'),
                'updateselesai' => Auth::user()->can('sewa updateselesai'),
            ],
            'Tab' => FacadesRequest::input('status'),
            'search' => FacadesRequest::input('search'),
            'page' => FacadesRequest::input('page'),
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
                ->StatusBayar(FacadesRequest::input('statusBayar'))
                ->orderBy('kode', 'desc')
                ->paginate(10),
            'can' => [
                'create' => Auth::user()->can('permission create'),
                'edit' => Auth::user()->can('permission edit'),
                'delete' => Auth::user()->can('permission delete'),
                'update' => Auth::user()->can('permission update'),
            ],
            'statusBayar'=> FacadesRequest::input('statusBayar', 'semua')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mobil = Mobil::where('status', '=', '2')->get();
        if ($mobil->count() < 1) {
            return Redirect::back()->with('error', 'Maaf Kendaraan Yang Tersedia Kosong atau Dalam Perbaikan');
        }
        $pengguna = Pengguna::all();
        $sopir = Sopir::all();
        return Inertia::render('Sewa/FormSewa', [
            'pengguna' => $pengguna,
            'mobil' => $mobil,
            'sopir' => $sopir,
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
        // dd($request->all());
        $request->validate([
            'jenis_sewa' => 'required',
            'nik' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required|numeric',
            'nama' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required|string',
            'tempat_lahir' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required|string',
            'tgl_lahir' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required|date',
            'pekerjaan' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required|string',
            'no_hp' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required',
            'no_hp_lain' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required',
            'unit' => 'required',
            'nopol' => 'required',
            'tahun' => 'required',
            'nilaisewahari' => 'required',
            'nilaisewabulan' => 'required',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date',
            'lama_sewa' => 'required',
            'tujuan' => 'required',
            'jaminan' => 'string|nullable',
        ]);
        $pengguna = Pengguna::with('sewa', 'sewa.waktusewa')->whereHas('sewa', function ($query) {
            $query->whereIn('status', ['2','3','4']);
        })
            ->where('nik', $request->nik)
            ->get();
        $mobil = Mobil::where('nopol', '=', $request->nopol)->where('status', '1')->get();
        // dd($pengguna->count(), $mobil->count());
        if ($mobil->count() > 0) {
            return Redirect::route('Sewa.index')->with('error', 'Maaf Kendaraan Sedang Disewa');
        }
        if ($pengguna->count() > 0) {
            return Redirect::route('Sewa.index')->with('error', 'Tunggakan Pembayaran Belum Lunas');
        }
        $dat = $request->all();
        // dd($dat);
        return Inertia::render('Sewa/Formulir', [
            'formulir' => $dat,
            'kode' => $this->kodeSewa(),
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
    public function show(Sewa $sewa, $id)
    {
        return Inertia::render('Sewa/Show', [
            'sewa' => $sewa->with(['pengguna', 'waktusewa'])->find($id)
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
    public function destroy(Sewa $sewa, $id)
    {
        $data = Sewa::find($id);
        $exp = explode(',', $data->nopol);
        Mobil::whereIn('nopol', $exp)->update(['status'=> '2']);
        $data->delete();
    }
    /**
     * StatusUpdate
     * Update Status Sewa
     * @param  mixed $Sewa
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function StatusUpdate(Sewa $Sewa, $id, Request $request)
    {
        $Sewa->find($id)->update([
            'status' => $request->status,
        ]);
    }


    private function reduceArrayMany($array)
    {
        $nilai = null;
        // dd($array);
        foreach($array as $item){
            $tambah_arr = null;
            if(strpos($item, ',') !== false){
                $hasil = explode(',', $item);
                for($i= 0; $i < count($hasil); $i++){
                    $tambah_arr .= $hasil[$i];
                }
                $nilai[] = $tambah_arr;
            }else{

                $nilai[] = $item;
            }
        }
        return $nilai;
    }
    private function reduceArray($array)
    {
        $nilai = null;
        // dd($array);
        $exp = explode(',', $array);
        foreach($exp as $item){
            $tambah_arr = null;
            if(strpos($item, ',') !== false){
                $hasil = explode(',', $item);
                for($i= 0; $i < count($hasil); $i++){
                    $tambah_arr .= $hasil[$i];
                }
                $nilai[] = $tambah_arr;
            }else{

                $nilai[] = $item;
            }
        }
        // dd(array_sum($nilai));
        return array_sum($nilai);
    }

    /**
     * CekSewaTelat
     * Mencari Dan Update Data Sewa Yang Telat
     * @return void
     */
    public function CekSewaTelat()
    {
        $carbon = Carbon::now()->format("Y-m-d");
        $jam_carbon = Carbon::now()->format('H:i:s');
        $sewa = Sewa::with('waktusewa')->whereHas('waktusewa', function ($query) use ($carbon) {
            $query->where('tgl_kembali', '<', $carbon);
        })->whereNotIn('status',  ['Selesai'])->get();
        $denda = 0.10;
        foreach ($sewa as $item) {
            $total_denda = abs($this->reduceArray($item->harga) * $denda);
            $jam_sewa = $item->waktusewa->jam_sewa;
            $waktu_kembali = Carbon::parse($item->waktusewa->tgl_kembali);
            $waktu_sekarang = Carbon::now();
            $diff = $waktu_sekarang->diffInHours($waktu_kembali);
            $nilai_denda = $total_denda * $diff;
            $sub_total = (intval($item->waktusewa->lama_sewa)  * $this->reduceArray($item->harga)) + $item->denda;
            // dd($nilai_denda);
            $item->update(['denda' => $nilai_denda, 'status' => "Telat", 'total' => $sub_total, 'status_bayar'=> '3']);
            WaktuSewa::where('sewa_id',  $item->id)->update(['telat' => $diff]);
        }
    }


    /**
     * CekTotal
     * fungsi Hitung Nilai Total
     * @return void
     */
    public function CekTotal()
    {
        $sewa = Sewa::with('waktusewa')->get();
        foreach ($sewa as $item) {
            $sub_total = (intval($item->waktusewa->lama_sewa)  * $this->reduceArray($item->harga)) + $item->denda;

            $item->update(['total' => $sub_total]);
        }
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
            'status_bayar' =>  $request->status_bayar,
        ]);
        $exp = explode(',', $sewa->nopol);
        Mobil::whereIn('nopol',  $exp)->update([
            'status' => $request->status == 'Selesai' ? '2' : '1',
        ]);
        return Redirect::back()->with('success', "Status Sewa ". $sewa->kode ." Berhasil Diganti ");

        // Synchronously
    }

    /**
     * updateTanggal
     * Update Tanggal Sewa
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function updateTanggal($id, Request $request)
    {
        $sewa = Sewa::find($id);
        $waktusewa = WaktuSewa::where('sewa_id', $sewa->id)->update([
            'tgl_kembali' => $request->tgl_kembali,
            'jam_kembali' => $request->jam_kembali,
            'lama_sewa' => $request->lama_sewa,
        ]);

        return Redirect::back()->with('success', "Perpanjang Sewa ". $sewa->kode ." Berhasil Diganti ");

        // Synchronously
    }
    public function kodeSewa()
    {
        $max_id = Sewa::max('id');
        $sewa = Sewa::all();
        if ($max_id == null) {
            $kode = 'S001';
        } else {
            $k = (int) substr($max_id, 0);
            $k++;
            $kode = 'S' . sprintf('%03s', $k);
        }
        return $kode;
    }

    public function generateKodeASC()
    {
        $max_id = Sewa::max('id');
        $sewa = Sewa::all();
        if ($max_id == null) {
            $kode = 'S001';
        } else {
            $k = (int) substr($max_id, 0);
            // $k++;
            $kode = 'S' . sprintf('%03s', $k);
        }
        foreach ($sewa as $key => $item) {
            // Sewa::find($item->id)->update(['kode' => $kode]);
            $k = (int) substr($key, 0);
            $kode = 'S' . sprintf('%03s', $k);
            $item->update(['kode' => $kode]);
        }
    }



}
