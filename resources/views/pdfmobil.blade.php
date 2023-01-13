<div>
    <table class=" bg-white  w-full mb-5">
        <tr>
            <td class="text-left ">
                <img src="{{ public_path('img/logo.png') }}" width="150" height="150" class="w-1/2 " alt="">
            </td>
            <td class="text-right  max-w-md uppercase">
                <span class="text-center font-bold underline text-lg">
                    CEKLIST UNIT DAN KELENGKAPAN KENDARAAN
                </span>
            </td>
        </tr>
    </table>


    <table class="w-full">
        <tr>
            <td class=" text-left font-bold uppercase">Unit Kendaraan :{{ $data->unit[$i] }}/

            </td>
            <td class=" text-left font-bold"></td>
            <td class=" text-left font-bold">
                NOPOL
            </td>
            <td class=" text-left font-bold">: {{ $data->nopol[$i] }}</td>
        </tr>
        <tr>
            <td class="text-left font-bold" colspan="2">&nbsp;</td>
            <td class="text-left font-bold" colspan="1">TANGGAL</td>
            <td class="text-left font-bold" colspan="1">: {{ $data->tgl_file }}</td>
        </tr>
    </table>


    <table class=" table w-full">
        <tr>
            <th class="border text-center">Body Kendaraan</th>
            <th class="border text-center">Keterangan</th>
        </tr>
        @php
            $namaSide = ['Foto Samping Kanan', 'Foto Samping Kiri', 'Foto Samping Depan', 'Foto Samping Belakang'];
            $foto = ['side-1.jpg', 'side-3.jpg', 'side-2.jpg', 'side-4.jpg'];
        @endphp
        @for ($i = 0; $i < count($foto); $i++)
            <tr>
                <td class="border-bottom-none text-center" rowspan="6" style="width: 200px;height:110px;">
                    <img src="{{ public_path('pdfimage/' . $foto[$i]) }}"  style="height: 110px;width:80%;" alt="">
                </td>
                <td class="border"></td>
            </tr>
            <tr>
                <td class="border"></td>
            </tr>
            <tr>
                <td class="border"></td>
            </tr>
            <tr>
                <td class="border"></td>
            </tr>
            <tr>
                <td class="border"></td>
            </tr>
            <tr>
                <td class="border"></td>
            </tr>
            <tr>
                <td class="border-top-none text-center" style="border-top: none !importamt;">
                    {{ $namaSide[$i] }}
                </td>
                <td class="border"></td>
            </tr>
        @endfor
    </table>
    <table class="table w-full border" border="1">
        <tr>
            <th class="border text-center" rowspan="2">Jenis Kelengkapan <br> Kendaraan</th>
            <th class="border text-center" colspan="2">Status</th>
            <th class="border text-center" rowspan="2">Keterangan</th>
            <th class="border text-center" rowspan="5">
                <img src="{{ public_path('pdfimage/jarum.png') }}" alt="Jarum.png" width="100">
            </th>
        </tr>
        <tr>
            <th class=" text-center border">Ada</th>
            <th class=" text-center border">Tidak Ada</th>
        </tr>
        <tr>
            <td class="border">Kunci Roda</td>
            <td class="border"></td>
            <td class="border"></td>
            <td class="border"></td>
        </tr>
        <tr>
            <td class="border">Dongkrak</td>
            <td class="border"></td>
            <td class="border"></td>
            <td class="border"></td>
        </tr>
        <tr>
            <td class="border">Kotak P3K</td>
            <td class="border"></td>
            <td class="border"></td>
            <td class="border"></td>
        </tr>
        <tr>
            <td class="border">Seigitiga Pengaman</td>
            <td class="border"></td>
            <td class="border"></td>
            <td class="border"></td>
            <td class="border">Posisi Jarum BBM</td>
        </tr>
        <tr>
            <td class="border">Tool Kit</td>
            <td class="border"></td>
            <td class="border"></td>
            <td class="border"></td>
            <td class="border">Start : </td>
        </tr>
        <tr>
            <td class="border">Ban Cadangan</td>
            <td class="border"></td>
            <td class="border"></td>
            <td class="border"></td>
            <td class="border">Kembali :</td>
        </tr>
    </table>
    <table class="table w-full ">

        <tr>
            <td class="text-center">&nbsp;</td>

            <td class="text-center">&nbsp;</td>
        </tr>
        <tr>
            <td class="text-center h-10 "><span
                    class="border-b-2 border-black">(..................................)</span></td>
            <td class="text-center h-10 "><span
                    class="border-b-2 border-black">(..................................)</span></td>
        </tr>
        <tr>
            <td class="text-center">Pemeriksa</td>


            <td class="text-center">Penyewa</td>
        </tr>
    </table>
</div>
