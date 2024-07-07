<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            font-size: 12px;
            line-height: 18px;
            font-family: 'Ubuntu', sans-serif;
        }

        h2 {
            font-size: 16px;
        }

        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }

        tr {
            border-bottom: 1px dashed #ddd;
        }

        td,
        th {
            padding: 7px 0;
            width: 50%;
        }

        table {
            width: 100%;
        }

        tfoot tr th:first-child {
            text-align: left;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        small {
            font-size: 11px;
        }

        @media print {
            * {
                font-size: 12px;
                line-height: 20px;
            }

            td,
            th {
                padding: 5px 0;
            }

            .hidden-print {
                display: none !important;
            }

            tbody::after {
                content: '';
                display: block;
                page-break-after: always;
                page-break-inside: auto;
                page-break-before: avoid;
            }
        }
    </style>
</head>

<body>

    <div style="max-width:400px;margin:0 auto">
        <div id="receipt-data">
            <div class="centered">
                <h2 style="margin-bottom: 5px">{{ settings()->company_name }}</h2>

                <p style="font-size: 11px;line-height: 15px;margin-top: 0">
                    {{ settings()->company_email }}, {{ settings()->company_phone }}
                    <br>{{ settings()->company_address }}
                </p>
            </div>
            <p>
                Date: 23423432<br>
                Reference: 23423423<br>
                Name: 234234
            </p>
            <table class="table-data">
                <tbody>
                    <tr>
                        <td colspan="2">
                            Sabun
                            1 x {{ format_currency(1000000) }}
                        </td>
                        <td style="text-align:right;vertical-align:bottom">
                            {{ format_currency(332423) }}</td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            Sabun
                            1 x {{ format_currency(1000000) }}
                        </td>
                        <td style="text-align:right;vertical-align:bottom">
                            {{ format_currency(332423) }}</td>
                    </tr>
                </tbody>

            </table>
            <table>

            </table>
        </div>
    </div>

</body>

</html>
