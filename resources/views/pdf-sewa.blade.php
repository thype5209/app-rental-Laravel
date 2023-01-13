<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $kode }}-{{ $data->nik }}</title>
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

    .ket_syarat {
        text-align: left;
    }

    .ket_syarat ul {
        list-style: disc;
        margin-left: 30px;
    }

    .border {
        border: 1px solid #000;
    }

    .border-top-none {
        border-top: 0;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
        border-bottom: 1px solid #000;
    }

    .border-bottom-none {
        border-bottom: 0;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
        border-top: 1px solid #000;
    }

    .header {
        width: 100%;
        height: max-content;
        display: flex;
        justify-content: center;
        border-bottom: 3px solid #000;
    }

    .table-header {
        position: relative;
        left: 6em;
    }

    span {
        text-transform: capitalize;
    }

    .page-break {
        page-break-after: always;
    }

    @page {
        margin: 20px 30px 40px 50px;
    }
    #numberpage:after { content: counter(page, decimal); }
    /* section.template { position: fixed; right: 0px; bottom: 10px; text-align: center;} */
</style>

<body>
    <section class="template">
        <main class="page">
            <section class=" top-0 pb-5 ">
                <!-- Head -->
                @include('kop', ['kode' => $kode])


                <table class="table w-max sm:w-1/4 md:w-1/3 mb-3">
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Lampiran</td>
                        <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                           <span id="numberpage"></span>
                        </td>
                    </tr>
                </table>
                <table class="table w-max sm:w-1/4 md:w-1/3 mb-1">
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">NIK</td>
                        <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $data->nik }}
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Nama</td>
                        <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $data->nama }}
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Tempat/Tanggal Lahir</td>
                        <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $data->tempat_lahir }}/{{ $data->tgl_lahir }} </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Pekerjaan</td>
                        <td class=" whitespace-nowrap mb-0 p-0">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:{{ $data->pekerjaan }}
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Alamat</td>
                        <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $data->alamat }}
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">No. HP</td>
                        <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $data->no_hp }}
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">No. HP Kerabat Lain</td>
                        <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $data->no_hp_lain }}</td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Sosial Media</td>
                        <td class=" whitespace-nowrap mb-0 p-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $data->sosial }}
                        </td>
                    </tr>
                </table>
                @php
                    $string = new \App\Http\Controllers\LaporanController();
                @endphp
                <p class="w-full text-justify">Dengan ini menyatakan bahwa pihak rental menitipkan kendaraan spesifikasi
                    kendaraan sebagai berikut.</p>
                <table class="table w-max border-b border-black h-max text-justify ">
                    @for ($i = 0; $i < count($data->nopol); $i++)
                        <tr class=" p-0 m-0">
                            <td class=" whitespace-nowrap mb-0">Jenis Kendaraan </td>
                            <td class=" whitespace-nowrap mb-0 px-3"> :
                                {{ $data->unit[$i] }}
                            </td>
                            <td class=" whitespace-nowrap mb-0 px-3">Nilai Sewa </td>
                            <td>
                                <span class=" whitespace-nowrap mb-0 "><span class="font-normal">:</span> Rp.
                                    {{ $data->nilaisewahari[$i] }} /Per Hari</span>
                            </td>
                        </tr>
                        <tr class=" p-0 m-0">
                            <td class=" whitespace-nowrap mb-0">No. Polisi </td>
                            <td class=" whitespace-nowrap mb-0 px-3"> :
                                {{ $data->nopol[$i] }}
                            </td>

                            <td class=" whitespace-nowrap mb-0 ">Total Sewa </td>
                            <td>
                                <span class=" whitespace-nowrap mb-0 px-3"><span class="font-normal">:</span> Rp.
                                    {{ $string->parseToNumber($data->nilaisewahari[$i]) * intval($data->lama_sewa) }}</span>
                            </td>
                        </tr>
                        <tr class=" p-0 m-0">
                            <td class=" whitespace-nowrap mb-0 ">Tahun </td>
                            <td class=" whitespace-nowrap mb-0 px-3"> :
                                {{ $data->tahun[$i] }}
                            </td>
                        </tr>
                    @endfor
                </table>
                <table class="table w-max  mb-1 h-max text-justify ">
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Tujuan </td>
                        <td class=" whitespace-nowrap mb-0 p-0 "> : {{ $data->tujuan }} </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Jaminan </td>
                        <td class=" whitespace-nowrap mb-0 p-0 "> : {{ $data->jaminan }} </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Tanggal/Jam Sewa </td>
                        <td class=" whitespace-nowrap mb-0 p-0"> : {{ $data->tgl_sewa }}/{{ $data->jam_sewa }} WITA
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Tanggal/Jam Kembali </td>
                        <td class=" whitespace-nowrap mb-0 p-0"> : {{ $data->tgl_kembali }}/{{ $data->jam_kembali }}
                            WITA
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Jumlah Hari </td>
                        <td class=" whitespace-nowrap mb-0 p-0"> : {{ $data->lama_sewa }}
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Total Bayar </td>
                        <td class=" whitespace-nowrap mb-0 p-0"> : {{ $data->total }}
                        </td>
                    </tr>

                </table>

                <!-- Keterangan -->
                <div class="ket_syarat">
                    {!! $data->ket_syarat !!}
                </div>
                <div class="container mx-auto mb-5 px-20" style="padding-left: 1rem; padding-right:1rem;">
                    <table class="table mt-3 border w-full">
                        <tr>
                            <th class=" capitalize bg-blue-200 border border-black">Panjar</th>
                            <th class=" capitalize bg-blue-200 border border-black">Sisa</th>
                            <th class=" capitalize bg-blue-200 border border-black">Lunas</th>
                        </tr>
                        <tr>
                            <td class="border border-black"> {{ $data->panjar }} </td>
                            <td class="border border-black"> {{ $data->sisa }}</td>
                            <td class="border border-black">
                                @php
                                    if ($data->lunas == '1') {
                                        $svg = 'Lunas';
                                    } elseif ($data->lunas == '3') {
                                        $svg = 'Belum Lunas';
                                    }
                                @endphp
                                {{ $svg }}
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- TTD -->
                <table class="table w-full ">
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
        </main>
        @if ($data->jenis_sewa == 'Lepas')
        @for ($i = 0; $i < count($data->unit); $i++)
        <main class="page">
        <div class="page-break"></div>
            @include('pdfmobil', ['data' => $data, 'i' => $i, 'kode' => $kode, 'tgl' => $tgl])
        </main>
        @endfor

    @endif
    </section>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                if ($PAGE_COUNT > 1 && $PAGE_COUNT < 2) {
                    $font = $fontMetrics->get_font("times-new-roman, Helvetica, sans-serif", "normal");
                    $size = 11;
                    $pageText = $PAGE_COUNT;
                    $y = 120;
                    $x = 100;
                    $pdf->text($x, $y, $pageText, $font, $size);
                }
            ');
        }
        </script>
</body>

</html>
