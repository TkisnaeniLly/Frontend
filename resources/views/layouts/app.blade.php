<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT SHOP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Fonts & Icons --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Style --}}
    <style>
        {!! file_get_contents(resource_path('css/style.css')) !!}

        /* Z-Index Fixes */
        #authModal {
            z-index: 3000 !important;
        }

        #quickViewModal {
            z-index: 2000 !important;
        }
    </style>
</head>

<body>

    {{-- Preloader --}}
    <div class="preloader" id="preloader">
        <div class="preloader-content">
            <div class="preloader-logo">IT SHOP</div>
            <div class="preloader-line"></div>
        </div>
    </div>

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Main Content --}}
    @yield('content')

    {{-- Footer --}}
    @include('components.footer')
    {{-- Modals --}}
    @include('modals.home')
    {{-- Script --}}
    <script>
        {!! file_get_contents(resource_path('js/script.js')) !!}
    </script>

</body>

</html>
