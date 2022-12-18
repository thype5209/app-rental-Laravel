<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Inertia\Inertia;
use App\Models\Pengguna;
use App\Models\Sewa;
use App\Models\WaktuSewa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index()
    {
        return Inertia::render('Laporan/LaporanSewa');
    }

    public function saveSewaCetak(Request $request)
    {
        return Inertia::render('Laporan/CetakSewaSave', [
            'pdf' => $request->pdf,
        ]);
    }
    public function saveSewa(Request $request)
    {
        // dd($request->all());
        $req = (object) $this->data();
        //buat pengguna
        $kode = 'S001';
        $path =  '/storage/SewaPDF/';
        $namaPDF = $path. $kode.'-'.$req->nama. '-'. $req->tgl_sewa. '.pdf';
        $this->createPengguna($req);
        $this->sewaCreate($req,$kode, $namaPDF);

        // Tanggal
        $carbon = $this->today();
        $pdf = Pdf::loadView('pdf-sewa', ['data' => $req, 'tgl' => $carbon]);

        Storage::put('public/SewaPDF/'. $namaPDF, $pdf->download()->getOriginalContent());
        // return $pdf->stream('sewa.pdf');
        return Redirect::route('Laporan.saveSewaDanCetak', ['pdf'=>$namaPDF]);
    }

    public function today()
    {
        $carbon = Carbon::now()->format('Y-m-d');
        $parse = explode('-', $carbon);
        $msg = '';
        switch ($parse[1]) {
            case '1':
                $msg = 'Januari';
                break;
            case '2':
                $msg = 'Februari';
                break;
            case '3':
                $msg = 'Maret';
                break;
            case '4':
                $msg = 'April';
                break;
            case '5':
                $msg = 'Mei';
                break;
            case '6':
                $msg = 'Juni';
                break;
            case '7':
                $msg = 'Juli';
                break;
            case '8':
                $msg = 'Agustus';
                break;
            case '9':
                $msg = 'September';
                break;
            case '10':
                $msg = 'Oktober';
                break;
            case '11':
                $msg = 'November';
                break;
            case '12':
                $msg = 'Desember';
                break;

            default:
                $msg = 'Error';
                break;
        }
        return $parse[0] .' '. $msg .' '. $parse[2];
    }
    public function data()
    {
        $data = [
            'mobil_id' => '1',
            'nik' => '91010',
            'nama' => 'wawan',
            'tempat_lahir' => 'Bulukumba',
            'tgl_lahir' => '19-10-2000',
            'alamat' => 'Makassar',
            'pekerjaan' => 'Mahasiswa',
            'sosial' => 'FB',
            'no_hp' => '081920019',
            'no_hp_lain' => '019020191',
            'nilaisewahari' => '20000',
            'nilaisewabulan' => '90000',
            'tgl_sewa' => '2022-12-01',
            'tgl_kembali' => '2022-12-10',
            'lama_sewa' => '10 hari',
            'tujuan' => 'Bulukumba',
            'jaminan' => 'KTP',
            'unit' => 'avanza',
            'nopol' => 'NK 002 B',
            'tahun' => '2022',
        ];
        return $data;
    }
    public function createPengguna($request)
    {
        $pengguna = Pengguna::where('nik', $request->nik)->get();
        if($pengguna->count() < 1){
            Pengguna::create([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'no_hp_lain' => $request->no_hp_lain,
                'pekerjaan' => $request->pekerjaan,
            ]);
        }
    }
    public function sewaCreate($request,$kode,$pdf_url)
    {
        $sewa = Sewa::create([
            'kode' => $kode,
            'nopol' => $request->nopol,
            'unit' => $request->unit,
            'tahun' => $request->tahun,
            'harga' => $request->nilaisewahari,
            'harga_bulan' => $request->nilaisewabulan,
            'nik' => $request->nik,
            'tujuan' => $request->tujuan,
            'jaminan' => $request->jaminan,
            'penanggung_jawab' => Auth::user()->name,
            'pdf_url'=> $pdf_url,
            'denda' => '0',
            'status' => '0',
        ]);
        WaktuSewa::create([
            'sewa_id' => $sewa->id,
            'tgl_sewa' => $request->tgl_sewa,
            // 'jam_sewa' => $request->jam_sewa,
            'tgl_kembali' => $request->tgl_kembali,
            // 'jam_kembali' => $request->jam_kembali,
            'lama_sewa' => $request->lama_sewa,
        ]);
    }
    public function waktu_sewa()
    {
    }
}
