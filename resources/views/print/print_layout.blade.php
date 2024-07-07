<html>

<head>

    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: Helvetica, Sans-Serif;
        }

        .test {
            line-height: 5px;
        }

        .content {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .title-laporan {
            line-height: 0px;
            margin-bottom: 30px;
            margin-top: 20px;
        }

        h3 {
            line-height: 0px;
        }

        p {
            font-size: 15px;
        }

        hr {
            position: relative;
            border: none;
            height: 3px;
            background: black;
        }

        .data {
            border-collapse: collapse;
            width: 100%;

            font-size: 10px;
        }

        .data td,
        .data th {
            border: 0.6mm solid #000000;
            /* padding: 3px; */
        }

        .data,
        .jarak {
            margin-left: 10px;
        }

        .footer {
            margin: 50px;
            font-weight: bold;
            font-size: 14px;
        }

        .noline td {
            border-top: none;
            border-bottom: none;

        }


        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            /** Extra personal styles **/
            background-color: #eaeaea;
            color: black;
            text-align: center;
            line-height: 1.5cm;
        }

        .tableFooter {
            width: 100%;
            font-size: 13px;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }

        /* Tambahkan border bawah pada elemen dengan kelas '.border-bottom' */
        .border-bottom {
            border-bottom: 0.6mm solid #000000;
        }

        .text-underline {
            text-decoration: underline;
        }

        .redd {
            color: red,
        }

        .bluee {
            color: blue,
        }
    </style>
</head>

<body>
    @php
    @endphp
    <main>
        <div class="header">
            <table width='100%' padding=0>
                <tr>
                    <td width='100px'>
                        <img src="{{ asset(settings()->site_logo) }}" width="100px">
                    </td>

                    <td align="center">
                        <div style="margin-top:20px;">

                            <h2 class="test">{{ settings()->company_name }}</h2>
                            <p class="test">{{ settings()->company_address }}</p>
                            <p class="test">Telp / Fax : {{ settings()->company_phone }}
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr size='7' />
                    </td>
                </tr>
            </table>
        </div>
        <div class="content">

            @section('content')
            @show
        </div>
        <div class="footer">
            <table class="tableFooter" align="center">
                <tr>
                    <td></td>
                    <td align="center"><b>{{ 23 }}
                            ,{{ tanggalIndonesia(date('Y-m-d')) }}</b>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><b>Pengurus</b> </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:50px;"></td>
                </tr>

                <tr>
                </tr>

                <tr>
                </tr>
            </table>
        </div>
    </main>

</body>

</html>
