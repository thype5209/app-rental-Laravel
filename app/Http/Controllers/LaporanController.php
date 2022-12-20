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


    /**
     * saveSewaCetak
     *  Tampilan Laporan Sewa Dengan Copy Link
     * @param  mixed $request
     * @return void
     */
    public function saveSewaCetak(Request $request)
    {
        return Inertia::render('Laporan/CetakSewaSave', [
            'pdf' => $request->pdf,
        ]);
    }

    public function kodeSewa()
    {
        $sewa = Sewa::max('kode');
        if ($sewa == null) {
            $kode = 'S001';
        } else {
            $k = substr($sewa, 1, 3);
            $k++;
            $kode = 'S' . sprintf('%03s', $k);
        }
        return $kode;
    }
    /**
     * saveSewa
     *  Menyimpan
     *  Generate PDF
     *  Dan Mereturn Data Ke Dalam Route Laporan Dan Cetak
     * @param  mixed $request
     * @return void
     */
    public function saveSewa(Request $request)
    {

        $req = $request;
        // Panggil Fungsi Kode
        $kode = $this->kodeSewa();
        $path =  'SewaPDF/';
        $namaPDF = $path . $kode . '-' . $req->nama . '-' . $req->tgl_sewa . '.pdf';
        //buat pengguna
        $this->createPengguna($req);
        $this->sewaCreate($req, $kode, $namaPDF);

        // Tanggal
        $carbon = $this->today();
        // Melakukan Load Data PDF
        $pdf = Pdf::loadView('pdf-sewa', ['data' => $req, 'tgl' => $carbon, 'kode' => $kode]);
        // Simpan File PDF Ke Public Storage
        Storage::put('public/' . $namaPDF, $pdf->download()->getOriginalContent());

        return Redirect::route('Laporan.saveSewaDanCetak', ['pdf' => $namaPDF]);
    }


    /**
     * today
     *  Fungis Membuat Tanggal Bahasa Indonesia
     * @return void
     */
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
        return $parse[0] . ' ' . $msg . ' ' . $parse[2];
    }

    /**
     * createPengguna
     * Tambah Data Pengguna
     * @param  mixed $request
     * @return void
     */
    public function createPengguna($request)
    {
        $pengguna = Pengguna::where('nik', $request->nik)->get();
        if ($pengguna->count() < 1) {
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


    /**
     * sewaCreate
     *  Request Memanggil Data Dari POST yang Berada Pada Form Formulir
     *  Kode Dari Fungsi Kode
     *  PDF_URL nama PDF dari fungs create
     * @param  mixed $request
     * @param  mixed $kode
     * @param  mixed $pdf_url
     * @return void
     */
    public function sewaCreate($request, $kode, $pdf_url)
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
            'pdf_url' => $pdf_url,
            'denda' => '0',
            'status' => 'Sewa',
        ]);
        WaktuSewa::create([
            'sewa_id' => $sewa->id,
            'tgl_sewa' => $request->tgl_sewa,
            'jam_sewa' => '00:00',
            'tgl_kembali' => $request->tgl_kembali,
            'jam_kembali' => "00:00",
            'lama_sewa' => $request->lama_sewa,
        ]);
        Mobil::find($request->mobil_id)->update([
            'status' => '1',
        ]);
    }
}
