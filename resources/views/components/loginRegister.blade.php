<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @vite('resources/css/app.css') --}}
    {{-- @stack('scripts') --}}
</head>
<body>
    <div class="container-xll vh-100 d-flex justify-content-center align-items-center" id="form-container">
        {{ $slot }}
    </div>
</body>
</html>