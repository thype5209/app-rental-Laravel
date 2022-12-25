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
                        $query->orderBy('kode', 'desc');
                    }
                })
                ->filter(FacadesRequest::only('search'))
                ->where('status', '!=', 'Selesai')
                ->paginate(10) ?? null,
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
                ->paginate(10),
            'can' => [
                'create' => Auth::user()->can('permission create'),
                'edit' => Auth::user()->can('permission edit'),
                'delete' => Auth::user()->can('permission delete'),
                'update' => Auth::user()->can('permission update'),
            ],
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
        $request->validate([
            'jenis_sewa' => 'required',
            'nik' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required|numeric',
            'nama' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required|string',
            'tempat_lahir' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required|string',
            'tgl_lahir' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required|date',
            'pekerjaan' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required|string',
            'no_hp' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required',
            'no_hp_lain' =>  $request->jenis_sewa == "Kunci" ? 'nullable' : 'required',
            'unit' => 'required|string',
            'nopol' => 'required|string',
            'tahun' => 'required|string',
            'nilaisewahari' => 'required|string',
            'nilaisewabulan' => 'required|string',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date',
            // 'lama_sewa' => 'required|string',
            'tujuan' => 'required|string',
            'jaminan' => 'string|nullable',
        ]);
        $pengguna = Pengguna::with('sewa', 'sewa.waktusewa')->whereHas('sewa', function ($query) {
            $query->whereIn('status', ['Sewa', 'Belum Dibayar', 'Telat']);
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
        $sewa->find($id)->delete();
    }
    public function StatusUpdate(Sewa $Sewa, $id, Request $request)
    {
        $Sewa->find($id)->update([
            'status' => $request->status,
        ]);
    }
    private function reduceArray($array)
    {
        $exp = explode(',', $array);
        $hasil = null;
        for ($i = 0; $i < count($exp); $i++) {
            $hasil .= $exp[$i];
        }
        return $hasil;
    }
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

            $item->update(['denda' => $nilai_denda, 'status' => "Telat", 'total' => $sub_total]);
            WaktuSewa::where('sewa_id',  $item->id)->update(['telat' => $diff]);
        }
    }
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
        ]);
        Mobil::where('nopol', '=', $sewa->nopol)->update([
            'status' => $request->status == 'Selesai' ? '2' : '1',
        ]);
        // Synchronously
    }
    public function updateTanggal($id, Request $request)
    {
        $sewa = Sewa::find($id);
        $waktusewa = WaktuSewa::where('sewa_id', $sewa->id)->update([
            'tgl_kembali' => $request->tgl_kembali,
            'lama_sewa' => $request->lama_sewa,
        ]);

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


    public function cekDowloadFile()
    {
        $foto = ['fotoMobil/M-0153.png', 'fotoMobil/M-0517.png', 'fotoMobil/M-0915.png', 'fotoMobil/M-0961.png'];
        $this->downloadFile($foto);
    }
    public function downloadFile(array $arr)
    {
        $zip = new ZipArchive;
        $file_name = 'arsip.zip';
        $collect = collect($arr);
        if(Storage::disk('public')->exists('ZipFile/arsip.zip')){
            Storage::disk('public')->delete('ZipFile/arsip.zip');
        }
        $zip->open(public_path() . '/storage/ZipFile/arsip.zip', ZipArchive::CREATE);
        foreach ($collect as $key => $item) {
            $zip->addFile(public_path() . '/storage/' . $item, $key . '.png');
        }
        $zip->close();

        // We return the file immediately after download
        return response()->download(public_path().'/storage/ZipFile/arsip.zip');
    }
}
