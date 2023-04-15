<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') {{ config('app.name', 'Laravel') }}</title>

    <!-- Refresh CSRF Token -->
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

    <!-- Logo -->
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png" sizes="16x16" />

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    <style type="text/css">
        bbody {
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 12pt !important;
            margin-top: 1cm !important;
            margin-left: 1cm !important;
            margin-right: 1cm !important;
            margin-bottom: 2cm !important;
        }

        @page {
            margin: 0cm 0cm !important;
        }

        footer {
            position: fixed !important;
            bottom: 1cm !important;
            left: 1cm !important;
            right: 0cm !important;
            font-size: 11pt !important;
        }

        .table {
            border-collapse: collapse;
            border: solid 1px #000;
            width: 100%
        }

        .table tr td,
        .table tr th {
            border: solid 1px #000;
            padding: 3px;
        }

        .table tr th {
            font-weight: bold;
            text-align: center
        }

        .rgt {
            text-align: right;
        }

        .ctr {
            text-align: center;
        }

        .tbl {
            font-weight: bold
        }

        table tr td {
            vertical-align: top
        }

        .font_kecil {
            font-size: 12px
        }

        div.footer {
            position: fixed;
            bottom: 0px;
        }

        @media screen {
            div.footer {
                display: none;
            }
        }

        @media print {
            div.footer {
                position: fixed;
                bottom: 0px;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            /* div.header-space {
                height: 100px;
            } */
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }
    </style>

    @vite(['resources/css/app.css'])

</head>

<body>
    @include('header')
    <div class="px-7">
        @yield('content')
    </div>
</body>

</html>
