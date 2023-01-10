<?php

namespace App\Http\Controllers;

use Exception;
use ZipArchive;
use Carbon\Carbon;
use App\Models\Sewa;
use Inertia\Inertia;
use App\Models\Mobil;
use App\Models\Pengguna;
use App\Models\WaktuSewa;
use App\Exports\SewaExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadeRequest;

class LaporanController extends Controller
{
    public function index()
    {
        return Inertia::render('Laporan/LaporanSewa', [
            'sewa' => Sewa::query()->with(['waktusewa', 'pengguna', 'user'])->where('status', '=', 'Selesai')
                ->dateFilter(FacadeRequest::only(['min', 'max']))->get(),
        ]);
    }


    /**
     * saveSewaCetak
     *  Tampilan Laporan Sewa Dengan Copy Link
     * @param  mixed $request
     * @return void
     */
    public function saveSewaCetak(Request $request)
    {
        $sewa = Sewa::where('kode', $request->kode)->with(['waktusewa', 'pengguna', 'user'])->first();
        return Inertia::render('Laporan/CetakSewaSave', [
            'pdf' => $request->pdf,
            'sewa' => $sewa,
        ]);
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
        // dd($request->all());

        // CekMobil
        $mobil = Sewa::where('nopol', $request->nopol)->whereIn('status', ['Sewa', 'Telat'])->get();
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
            'nik' => '91010',
            'nama' => 'wawan',
            'tempat_lahir' => 'Bulukumba',
            'tgl_lahir' => '19-10-2000',
            'alamat' => 'Makassar',
            'pekerjaan' => 'Mahasiswa',
            'sosial' => 'FB',
            'no_hp' => '081920019',
            'no_hp_lain' => '019020191',
            'tgl_sewa' => '2022-12-01',
            'tgl_kembali' => '2022-12-10',
            'lama_sewa' => '10',
            'tujuan' => 'Bulukumba',
            'jaminan' => 'KTP',
            'lunas' => 'false',
            'mobil_id' => ['1', '2'],
            'nilaisewahari' => ['20000', '30,000'],
            'nilaisewabulan' => ['90000', '800000'],
            'unit' => ['avanza', 'Jaguar'],
            'nopol' => ['NK 0012', 'DD JSK 99'],
            'tahun' => ['2022', '2021'],
            'panjar' => '0',
            'sisa' => '0',
        ];
        $req = (object) $data;
        // Panggil Fungsi Kode
        $cek = intval(array_sum($req->nilaisewahari)) * intval($req->lama_sewa);
        $kode = $this->kodeSewa();
        $path =  'SewaPDF/';
        $namaPDF = $path . $kode . '-'  . $req->tgl_sewa . '.pdf';
        //buat pengguna

        // Tanggal
        $carbon = $this->today();
        $mobil = Mobil::whereIn('id', $req->mobil_id)->get();
        // Melakukan Load Data PDF
        $pdf = Pdf::loadView('pdf-sewa', ['data' => $req, 'tgl' => $carbon, 'kode' => $kode, 'mobil' => $mobil]);
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
        $nama_ktp = null;
        if ($request->file('foto_ktp') != null) {
            $nama_ktp = $request->nik . '.' .  $request->foto_ktp->getClientOriginalName();
            $request->file('foto_ktp')->storeAs('public/FotoKTP', $nama_ktp);
        }
        if ($pengguna->count() < 1) {
            Pengguna::create([
                'foto_ktp' => $nama_ktp,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'no_hp_lain' => $request->no_hp_lain,
                'pekerjaan' => $request->pekerjaan,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
            ]);
        } else {
            foreach ($pengguna as $item) {
                $item->update(['foto_ktp' => $nama_ktp]);
            }
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
        $status_bayar = '3';
        if ($request->sisa == null) {
            $status_bayar = '1';
        }
        $sewa = Sewa::create([
            'jenis_sewa' => $request->jenis_sewa,
            'kode' => $kode,
            'nopol' => implode(',', $request->nopol),
            'unit' => implode(',', $request->unit),
            'tahun' => implode(',', $request->tahun),
            'harga' => implode(',', $this->parseStringToNumber($request->nilaisewahari)),
            'harga_bulan' => implode(',', $this->parseStringToNumber($request->nilaisewabulan)),
            'nik' => $request->nik,
            'sopir_id' => $request->sopir_id,
            'tujuan' => $request->tujuan,
            'jaminan' => $request->jaminan,
            // Penanggung Jawab Bersal Dari Data User ID
            'penanggung_jawab' => Auth::user()->id,
            'pdf_url' => $pdf_url,
            'denda' => '0',
            'status' => 'Sewa',
            'sisa' => abs($request->sisa),
            'status_bayar' => $status_bayar,
            'metode_bayar' => $request->metode_bayar,
            'list_pengiriman' => $request->list_pengiriman,
            'total' => intval(array_sum($this->parseStringToNumber($request->nilaisewahari))) * intval($request->lama_sewa),
        ]);
        WaktuSewa::create([
            'sewa_id' => $sewa->id,
            'tgl_sewa' => $request->tgl_sewa,
            'jam_sewa' => $request->jam_sewa,
            'tgl_kembali' => $request->tgl_kembali,
            'jam_kembali' => $request->jam_kembali,
            'lama_sewa' => $request->lama_sewa,
        ]);
        Mobil::whereIn('id', $request->mobil_id)->update([
            'status' => '1',
        ]);
    }
    public function parseStringToNumber($string_array)
    {
        $nilai = null;
        foreach ($string_array as $item) {
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
    public function CetakPDF()
    {
        $data =  Sewa::query()->with(['waktusewa', 'pengguna', 'user'])
            ->where('status', '=', 'Selesai')
            ->dateFilter(FacadeRequest::only(['min', 'max']))
            ->get();
        $pdf = Pdf::loadView('cetak-pdf', ['data' => $data]);
        // Simpan File PDF Ke Public Storage
        $path =  'PdfFILE/';
        $namaPDF = $path . 'PDFExport.pdf';

        $filePATH = public_path() . '/storage/' . $namaPDF;
        if (Storage::disk('public')->exists('PdfFile/PDFExport.pdf')) {
            Storage::disk('public')->delete('PdfFile/PDFExport.pdf');
        }

        $pdf = PDF::loadView('cetak-pdf', ['data' => $data]);
        Storage::put('public/' . $namaPDF, $pdf->download()->getOriginalContent());
        return response()->download($filePATH);
    }
    public function CetakEXCEL()
    {
        $file_name = '';
        $path =  'PdfFILE/';
        $namaPDF = $path . 'excelExport.xlsx';
        $filePATH = public_path() . '/storage/' . $namaPDF;

        try {
            // to download directly need to return file
            return Excel::download((new SewaExport(FacadeRequest::input('min'), FacadeRequest::input('max'))), 'excelExport.xlsx', null, [\Maatwebsite\Excel\Excel::XLSX]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function cekDowloadFile()
    {
        $sewa = Sewa::query()->with(['waktusewa', 'pengguna', 'user'])
            ->where('status', '=', 'Selesai')
            ->dateFilter(FacadeRequest::only(['min', 'max']))
            ->get();

        if (Storage::disk('public')->exists('ZipFile/arsip.zip')) {
            Storage::disk('public')->delete('ZipFile/arsip.zip');
        }
        $this->downloadFile($sewa);
        // dd($sewa);
        if (FacadeRequest::input('clear', false)) {
            Sewa::query()->with(['waktusewa', 'pengguna', 'user'])
                ->where('status', '=', 'Selesai')
                ->dateFilter(FacadeRequest::only(['min', 'max']))
                ->delete();
        }
        // return FacadeRequest::only(['min', 'max']);
        return response()->download(public_path() . '/storage/ZipFile/arsip.zip');
    }
    /**
     * downloadFile
     *  cari dan dowload semua file
     * @param  mixed $arr
     * @return void
     */
    public function downloadFile($sewa)
    {
        $zip = new ZipArchive;

        $zip->open(public_path() . '/storage/ZipFile/arsip.zip', ZipArchive::CREATE);
        // dd(public_path('storage/fotoMobil/Avanza-car-side.png'));
        $zip->addFile(public_path('storage/fotoMobil/Avanza-car-side.png'), 'mobil.png');
        foreach ($sewa as $key => $item) {
            if (Storage::disk('public')->exists($item->pdf_url)) {
                $zip->addFile(public_path() . '/storage/' . $item->pdf_url, $item->pdf_url);
            }
        }
        $zip->close();

        // We return the file immediately after download
    }

    public function destroyAll()
    {
        $data = FacadeRequest::input('data');
        $sewa = Sewa::whereIn('id', $data)->delete();

        return response()->json('Berhasil');
    }
}
