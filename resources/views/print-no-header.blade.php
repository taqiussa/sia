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
    <link rel="icon" href="{{ asset('images/logoalfa2.png') }}" type="image/png" sizes="16x16" />

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    @vite(['resources/css/app.css'])

</head>

<body>
    <div class="pl-10">
        @yield('content')
    </div>
</body>

</html>
