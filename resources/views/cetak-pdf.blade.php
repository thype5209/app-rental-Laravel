<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PDF</title>
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

    .border {
        border: 1px solid #000;
    }
    .border-top-none{
        border-top: 0;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
        border-bottom: 1px solid #000;
    }
    .border-bottom-none{
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
        left: 7em;
    }

    span {
        text-transform: capitalize;
    }

    .page-break {
        page-break-after: always;
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
    </section>
</body>

</html>
