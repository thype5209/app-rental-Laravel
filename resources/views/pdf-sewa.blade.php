<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $kode }}-{{ $data->nik }}/{{ $data->nopol }}</title>
    <link rel="stylesheet" type="text/css" href="{{ public_path('/css/pdfstyle.css') }}">
</head>

<style>
    * {
        font-size: 13px !important;
        font-family: 'Times New Roman', Times, serif;
    }

    body {
        padding-left: 4rem;
        padding-right: 4rem;
    }
    .header{
        width: 100%;
        height: max-content;
        display: flex;
        justify-content: center;
        border-bottom: 3px solid #000;
    }
    .table-header{
        position: relative;
        left: 7em;
    }
    span{
        text-transform: capitalize;
    }
</style>

<body>
    <section class=" md:w-[70%] py-5 px-3 bg-white sm:px-10 md:px-20">
        <!-- Head -->
        <div class="w-full header opacity-80 border-b-4 border-black py-3">
            <table class=" bg-white table  table-header">
                <tr>
                    <td class="text-right ">
                        <img src="{{ public_path('img/logo.png') }}" width="100" height="100" class="w-1/2 "
                    alt="">
                    </td>
                    <td class="text-left  max-w-md">
                        <ul class="text-left">
                            <li class="text-orange-500 font-bold text-center">CV. JASA SAUDAGAR</li>
                            <li class="font-bold text-base text-center">JL. MASJID RAYA No. 72 A Kab. GOWA</li>
                            <li class=" text-center"><span>Tlp( 0411 )8985984, mobile 0811 4145 999</span></li>
                            <li class=" text-center">
                                <span>Email : <a style="color: blue"
                                        href="mailto:cvjasasaudagar@gmail.com">cvjasasaudagar@gmail.com</a>
                                </span>
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>

        <table class="table w-full bg-white">
            <tr class=" p-0 m-0">
                <td colspan="4" class="text-center flex flex-col ">
                    <span class="text-center font-bold underline">SURAT PERNYATAAN SEWA KENDARAAN</span><br>
                    <span class="font-semibold">No:{{ $kode }}</span>
                </td>
            </tr>

        </table>
        <table class="table w-max sm:w-1/4 md:w-1/3 mb-5">
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0">NIK</td>
                <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->nik }} </td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0">Nama</td>
                <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->nama }} </td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0">Tempat/Tanggal Lahir</td>
                <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->tempat_lahir }}/{{ $data->tgl_lahir }} </td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0">Pekerjaan</td>
                <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:{{ $data->pekerjaan }}</td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0">Alamat</td>
                <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->alamat }}</td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0">No. HP</td>
                <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->no_hp }} </td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0">No. HP Kerabat Lain</td>
                <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->no_hp_lain }}</td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0">Sosial Media</td>
                <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->sosial }}</td>
            </tr>
        </table>
        <p class="w-full text-justify font-bold">Dengan ini menyatakan bahwa pihak rental menitipkan kendaraan
            kepada saya dengan spesipikasi kendaraan sebagai berikut.</p>
        <table class="table w-max sm:w-1/4 md:w-1/2 mb-5 h-max text-justify ">
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0 font-bold">Jenis Kendaraan</td>
                <td class=" whitespace-nowrap mb-0 p-0">
                    <span>
                        <span class="font-bold capitalize" >:</span>&nbsp;&nbsp;
                        {{ $data->unit }}
                    </span>
                    <span class=" whitespace-nowrap mb-0 p-0 font-bold">No. Kendaraan</span>
                    <span>
                        <span class="font-bold capitalize">:</span>
                        {{ $data->nopol }}&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <span class=" whitespace-nowrap mb-0 p-0 font-bold">Tahun</span>
                    <span>
                        <span class="font-bold capitalize">:</span>
                        {{ $data->tahun }}
                    </span>
                </td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0 font-bold">Nilai Sewa</td>
                <td>
                    <span class=" whitespace-nowrap mb-0 p-0"><span class="font-bold">:</span> Rp. {{ $data->nilaisewahari }} /Per Hari</span>
                    <span class=" whitespace-nowrap mb-0 p-0"><span class="font-bold">:</span> Rp. {{ $data->nilaisewabulan }} /Per Bulan</span>

                </td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0 font-bold">Masa Sewa</td>
                <td class=" whitespace-nowrap mb-0 p-0"><span class="font-bold">:</span>{{ $data->lama_sewa }}
                </td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0 font-bold">Tujuan</td>
                <td class=" whitespace-nowrap mb-0 p-0 "><span class="font-bold">:</span> {{ $data->tujuan }} </td>
            </tr>
            <tr class=" p-0 m-0">
                <td class=" whitespace-nowrap mb-0 p-0 font-bold">Jaminan</td>
                <td class=" whitespace-nowrap mb-0 p-0 "><span class="font-bold">:</span> {{ $data->jaminan }} </td>
            </tr>
        </table>

        <!-- Keterangan -->
        <div class="">
            <h3 class=" font-bold">Ket.</h3>
            <ul class="list-disc  px-10">
                <li class="text-justify">Apabila penyewa akan memperpanjang sewa kendaraan maka harus di
                    konfirmasi
                    ke pihak rental.</li>
                <li class="text-justify">Jika penyewa terlamabat mengembalikan mobil dalam waktu yang di
                    tentukan
                    maka akan di kenakan biaya over time 10% per jam darai harga sewa per harinya</li>
                <li class="text-justify">Apa bila pemakain sewa kendaraan tidak sesuai dengan Tujuan penyewa
                    yang di
                    tentukan penyewa, maka akan di kenakan biaya tambahan sesuai dengan zona-zona yang berlaku.
                </li>
            </ul>
            <h3 class=" font-bold">Penyewa bersedia menyanggupi syarat dan ketentuan penyewa kendaraan di bawah
                ini
                :.</h3>
            <ul class="list-disc  px-10">
                <li>Bertanggung jawab segala kerusakan, kehilangan kendaraan atau bagian-bagiannya</li>
                <li>Kendaraan tersebut tidak dapat digadaikan atau merubah bentuk aslinya</li>
                <li>Pemilik tidak bertanggung jawab atas kegiatan operasionalpenyewa kendaraan</li>
                <li>Penyewa tidak di benarkan membawa kendaraan selain tujuan diatas</li>
                <li>Melunasi sewa mobil dan segala bentuk tagihan jika terjadi kerusakan dan biaya kerugian
                    selama
                    di bengkel.</li>
                <li>Penyewa bersedia dituntut pidana apabila melanggar poin-poin diatas</li>

            </ul>
        </div>
        <!-- TTD -->
        <table class="table w-full mt-10 ">
            <tr>
                <td colspan="3" class="text-right"> Makassar, {{ $tgl }}</td>
            </tr>
            <tr>
                <td class="text-center">Direktur CV. JASA SAUDAGAR <br> Diketahui</td>

                <td>&nbsp;</td>

                <td class="text-center">YANG MEMBUAT PERNYATAAN</td>
            </tr>
            <tr>
                <td class="text-center">&nbsp;</td>

                <td>&nbsp;</td>

                <td class="text-center">&nbsp;</td>
            </tr>
            <tr>
                <td class="text-center">&nbsp;</td>

                <td>&nbsp;</td>

                <td class="text-center">&nbsp;</td>
            </tr>
            <tr>
                <td class="text-center h-10 "><span
                        class="border-b-2 border-black">(..................................)</span></td>
                <td class="text-center h-10 "><span
                        class="border-b-2 border-black">(..................................)</span></td>
                <td class="text-center h-10 "><span
                        class="border-b-2 border-black">(..................................)</span></td>
            </tr>
            <tr>
                <td class="text-center">Yang Menyerahkan Kendaraan</td>

                <td class="text-center">Saksi</td>

                <td class="text-center">Penyewa</td>
            </tr>
        </table>
    </section>
</body>

</html>
