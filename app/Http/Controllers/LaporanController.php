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

        // CekMobil
        $mobil = Sewa::where('nopol', $request->nopol)->whereIn('status', ['Sewa'])->get();
        if ($mobil->count() > 0) {
            return Redirect::route('Sewa.index')->with('error', 'Mobil Dalam Penyewaan');
        } else {
            $req = $request;
            // Panggil Fungsi Kode
            $kode = $this->kodeSewa();
            $path =  'SewaPDF/';
            $namaPDF = $path . $kode . '-'  . $req->tgl_sewa . '.pdf';
            //buat pengguna
            $this->createPengguna($req);
            $this->sewaCreate($req, $kode, $namaPDF);

            // Tanggal
            $carbon = $this->today();
            // Melakukan Load Data PDF
            $mobil = Mobil::where('nopol', $req->nopol)->first();

            $pdf = Pdf::loadView('pdf-sewa', ['data' => $req, 'tgl' => $carbon, 'kode' => $kode, 'mobil' => $mobil]);
            // Simpan File PDF Ke Public Storage
            Storage::put('public/' . $namaPDF, $pdf->download()->getOriginalContent());

            return Redirect::route('Laporan.saveSewaDanCetak', ['pdf' => $namaPDF]);
        }
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
        return $parse[2] . ' ' . $msg . ' ' . $parse[0];
    }
    public function TESTdata()
    {
        $data = [
            'jenis_sewa' => 'Kunci',
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
            'nopol' => 'NK 0012',
            'tahun' => '2022',
        ];
        $req = (object) $data;
        // Panggil Fungsi Kode
        $kode = $this->kodeSewa();
        $path =  'SewaPDF/';
        $namaPDF = $path . $kode . '-'  . $req->tgl_sewa . '.pdf';
        //buat pengguna

        // Tanggal
        $carbon = $this->today();
        $mobil = Mobil::where('nopol', $req->nopol)->first();
        // Melakukan Load Data PDF
        $pdf = Pdf::loadView('pdf-sewa-test', ['data' => $req, 'tgl' => $carbon, 'kode' => $kode, 'mobil' => $mobil]);
        return $pdf->stream();
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
        if ($pengguna->count() < 1 && $request->jenis_sewa == "Lepas") {
            Pengguna::create([
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
            'jenis_sewa' => $request->jenis_sewa,
            'kode' => $kode,
            'nopol' => $request->nopol,
            'unit' => $request->unit,
            'tahun' => $request->tahun,
            'harga' => $request->nilaisewahari,
            'harga_bulan' => $request->nilaisewabulan,
            'nik' => $request->nik,
            'sopir_id' => $request->sopir_id,
            'tujuan' => $request->tujuan,
            'jaminan' => $request->jaminan,
            // Penanggung Jawab Bersal Dari Data User ID
            'penanggung_jawab' => Auth::user()->id,
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
