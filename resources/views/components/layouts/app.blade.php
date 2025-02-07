<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/img/bs-logo-white.png">
    <title>Bridgestone</title>

    @vite(['resources/css/app.css'])

    {{-- dropzone --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.css">
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>

    {{-- select 2 --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>   
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .searching-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .searching-scrollbar::-webkit-scrollbar-thumb {
            background-color: #b0b0b0;
            border-radius: 4px;
        }
    </style>
</head>

    <body>

        @include('layouts.sidebar.sidebar')
        
        <div class="p-4 sm:ml-64">
            <div class=" mt-14">
                {{ $slot }}
            </div>
        </div>

        @vite(['resources/js/app.js'])
        @stack('scripts')
        
    </body>

</html>
