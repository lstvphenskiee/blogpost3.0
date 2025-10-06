<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="d-flex">
        <x-nav />

        <div class="container">
            {{ $slot }}
        </div>
    </div>

    {{-- Modal Overlay --}}
    <div id="modal-overlay" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" style="z-index:1050;">
        <div id="modal" class="position-absolute top-50 start-50 translate-middle bg-white p-4 rounded shadow" style="max-width:600px; width:90%;">
            {{-- Content --}}
        </div>
    </div>
</body>
</html>
