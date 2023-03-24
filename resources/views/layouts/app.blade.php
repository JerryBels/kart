<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kart</title>

    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    @vite('resources/css/app.css')


    @livewireStyles
</head>
<body class="bg-secondary-subtle">
<header>
    <h1 class="text-capitalize text-center fw-semibold font-monospace p-2"><i class="bi bi-bicycle"></i> Hello FortNine! <i class="bi bi-bicycle"></i></h1>
</header>

{{ $slot }}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@vite('resources/js/app.js')
@livewireScripts
</body>
</html>
