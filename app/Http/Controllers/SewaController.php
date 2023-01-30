<?php

namespace App\Http\Controllers;

use Exception;
use ZipArchive;
use Carbon\Carbon;
use App\Models\Sewa;
use Inertia\Inertia;
use App\Models\Mobil;
use App\Models\Sopir;
use App\Models\Pengguna;
use App\Models\WaktuSewa;
use App\Models\SewaPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSewaRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateSewaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;

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
            'sewa' =>  Sewa::with(['pengguna', 'waktusewa', 'user', 'sewapengguna'])
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
                ->with(['pengguna', 'waktusewa','sewapengguna'])
                ->orderBy('status', 'asc')
                ->where('status', 'Selesai')
                ->filter(FacadesRequest::only('search'))
                ->StatusBayar(FacadesRequest::input('statusBayar'))
                ->orderBy('kode', 'desc')
                ->paginate(10),
            'can' => [
                'create' => Auth::user()->can('sewa create'),
                'edit' => Auth::user()->can('sewa edit'),
                'delete' => Auth::user()->can('sewa delete'),
                'update' => Auth::user()->can('sewa update'),
                'updateselesai' => Auth::user()->can('sewa updateselesai'),
            ],
            'statusBayar' => FacadesRequest::input('statusBayar', 'semua')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mobil = Mobil::all();

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
            'nik' => 'required|numeric|min:30',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tgl_lahir' => 'required|date',
            'pekerjaan' => 'required|string',
            'no_hp' => 'required',
            'no_hp_lain' => 'required',
            'unit' => 'required',
            'nopol' => 'required',
            'tahun' => 'required',
            'nilaisewahari' => 'required',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date',
            'lama_sewa' => 'required',
            'tujuan' => 'required',
            // 'status_bayar' => 'required',
            'metode_bayar' => 'required',
            'list_pengiriman' => 'string|nullable|max:100',
            'lunas' => 'required',
            'tgl_file' => 'required',
            'panjar' => $request->lunas == 1 ? 'nullable' : 'required',
            'sisa' => $request->lunas == 1 ? 'nullable' : 'required',
            'jaminan' => 'string|nullable',
        ]);
        $pengguna = Pengguna::with('sewa', 'sewa.waktusewa')->whereHas('sewa', function ($query) {
            $query->whereIn('status', ['2', '3', '4']);
        })
            ->where('nik', $request->nik)
            ->get();
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
        $data = $sewa->with(['pengguna', 'waktusewa', 'user', 'sopir','sewapengguna'])->find($id);
        return Inertia::render('Sewa/Show', [
            'sewa' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sewa  $sewa
     * @return \Illuminate\Http\Response
     */
    public function edit(Sewa $sewa, $id)
    {
        return Inertia::render('Sewa/Edit', [
            'sewa' => $sewa->with(['waktusewa', 'sopir', 'pengguna','sewapengguna'])->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSewaRequest  $request
     * @param  \App\Models\Sewa  $sewa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sewa $sewa, $id)
    {

        $valid =  $this->validate($request, [
            'nopol' => ['required'],
            'nik' => ['required', 'max:30'],
            'jenis_sewa' => ['required'],
            'unit' => ['required'],
            'tahun' => ['required'],
            'harga' => ['required', 'max:100'],
            'sopir_id' => ['nullable'],
            'tujuan' => ['required', 'max:100'],
            'jaminan' => ['required', 'max:100'],
            'tgl_sewa' => ['required', 'date'],
            'jam_sewa' => ['required'],
            'jam_kembali' => ['required'],
            'tgl_kembali' => ['required', 'date'],
            'lama_sewa' => ['required', 'numeric'],
            'total' => ['required', 'string', 'max:50'],
            'metode_bayar' => ['required'],
            'nilai_denda' => ['required', 'numeric', 'max:10'],
            'list_pengiriman' => ['required', 'max:100'],
        ]);
        // Sewa::find($id)->update([
        //     'nik' => $request->nik,
        //     'jenis_sewa' => $request->jenis_sewa,
        //     'nopol' => implode(',',$request->nopol),
        //     'unit' => implode(',',$request->unit),
        //     'tahun' => implode(',',$request->tahun),
        //     'harga' => implode(',',$request->harga),
        //     'sopir_id' => $request->sopir_id,
        //     'tujuan' => $request->tujuan,
        //     'jaminan' => $request->jaminan,
        //     'panjar'=> $request->panjar,
        //     'sisa'=> $request->sisa,
        //     'total' => $request->total,
        //     'metode_bayar' => $request->metode_bayar,
        //     'list_pengiriman' => $request->list_pengiriman,
        // ]);
        // WaktuSewa::where('sewa_id', $id)->update([
        //     'tgl_sewa' => $request->tgl_sewa,
        //     'jam_sewa' => $request->jam_sewa,
        //     'jam_kembali' => $request->jam_kembali,
        //     'tgl_kembali' => $request->tgl_kembali,
        //     'lama_sewa' => $request->lama_sewa,
        // ]);

        return Redirect::route('Laporan.UpdateSewa', ['id'=> $id]);
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
        if (Storage::disk('public')->exists($data->pdf_url)) {
            Storage::disk('public')->delete($data->pdf_url);
        }
        Mobil::whereIn('nopol', $exp)->update(['status' => '2']);
        Sopir::where('id', $data->sopir_id)->update(['status' => '1']);
        SewaPengguna::where('sewa_id',$id)->delete();
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
        foreach ($array as $item) {
            $tambah_arr = null;
            if (strpos($item, ',') !== false) {
                $hasil = explode(',', $item);
                for ($i = 0; $i < count($hasil); $i++) {
                    $tambah_arr .= $hasil[$i];
                }
                $nilai[] = $tambah_arr;
            } else {

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
        foreach ($exp as $item) {
            $tambah_arr = null;
            if (strpos($item, ',') !== false) {
                $hasil = explode(',', $item);
                for ($i = 0; $i < count($hasil); $i++) {
                    $tambah_arr .= $hasil[$i];
                }
                $nilai[] = $tambah_arr;
            } else {

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
            // if($item->nilai_denda !== null){
            //     $denda = $item->nilai_denda;
            // }
            // $total_denda = abs($this->reduceArray($item->harga) * $denda);
            // dd($total_denda);
            // $jam_sewa = $item->waktusewa->jam_sewa;
            $waktu_kembali = Carbon::parse($item->waktusewa->tgl_kembali);
            $waktu_sekarang = Carbon::now();
            $diff = $waktu_sekarang->diffInHours($waktu_kembali);
            // $nilai_denda = $total_denda * $diff;

            $sub_total = (intval($item->waktusewa->lama_sewa)  * $this->reduceArray($item->harga)) + $item->denda;
            // dd($this->reduceArray($item->harga),(intval($item->waktusewa->lama_sewa)  * $this->reduceArray($item->harga)), $item->kode, $item->waktusewa->lama_sewa, $item->denda, $sub_total);
            // dd($nilai_denda);
            $item->update(['denda' => '0', 'status' => "Telat", 'total' => '0', 'status_bayar' => '3']);
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
        try {
            $sewa = Sewa::find($id);
            $sewa->update([
                'status' =>  $request->status,
                'status_bayar' =>  $request->status_bayar,
            ]);
            // dd($request->all());
            if ($request->status == 'Selesai') {
                $exp = explode(',', $sewa->nopol);
                Mobil::whereIn('nopol',  $exp)->update([
                    'status' => $request->status == 'Selesai' ? '2' : '1',
                ]);
                Sopir::where('id', $sewa->sopir_id)->update(['status' => '1']);
            }
            return Redirect::back()->with('success', "Status Sewa " . $sewa->kode . " Berhasil Diganti ");
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }

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

        return Redirect::back()->with('success', "Perpanjang Sewa " . $sewa->kode . " Berhasil Diganti ");

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
