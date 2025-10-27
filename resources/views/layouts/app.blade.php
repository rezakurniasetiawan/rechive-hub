<!DOCTYPE html>
<html lang="en">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- 🪶 Branding ReChive Hub -->
    <title>ReChive Hub — Personal Life & Finance Dashboard</title>
    <meta name="description"
        content="ReChive Hub adalah ruang digital pribadi untuk Reza & Chelsa — mengatur keuangan, aktivitas, rencana hidup, dan catatan penting dalam satu tempat yang indah dan bermakna." />
    <meta name="keywords"
        content="ReChive Hub, personal dashboard, finance management, relationship planner, life organizer, couple app, budgeting, habit tracker" />
    <meta name="author" content="ReChive Hub Team" />

    <!-- 🌈 Favicon -->
    <link href="{{ asset('dist/images/rechive-logo.svg') }}" rel="shortcut icon" />

    <!-- 🌿 CSS Assets -->
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />

    <!-- 💙 Theme Color -->
    <meta name="theme-color" content="#4F46E5" />

    <!-- 📱 Apple Touch Icon -->
    <link rel="apple-touch-icon" href="{{ asset('dist/images/rechive-logo.svg') }}" />

    <!-- ⚡ Open Graph (for social media preview) -->
    <meta property="og:title" content="ReChive Hub — Personal Dashboard" />
    <meta property="og:description"
        content="Kelola keuangan, aktivitas, dan kehidupan bersama dalam satu dashboard personal ReChive Hub." />
    <meta property="og:image" content="{{ asset('dist/images/og-rechive.png') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://rechivehub.app" />

    <!-- 🎉 SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<!-- END: Head -->

<body class="app">
    <!-- BEGIN: Mobile Menu -->
    @include('partials.mobile-menu')
    <!-- END: Mobile Menu -->
    <div class="flex">
        <!-- BEGIN: Side Menu -->
        @include('partials.sidebar')
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            <!-- BEGIN: Top Bar -->
            @include('partials.topbar')
            <!-- END: Top Bar -->

            {{-- Dynamic Page Content --}}
            {!! $content ?? '' !!}
        </div>
        <!-- END: Content -->
    </div>

    <!-- BEGIN: JS Assets -->
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=[your-google-map-api]&libraries=places"></script>
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <!-- END: JS Assets-->

    <!-- 💬 Flash Message Handling (SweetAlert2) -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#4F46E5',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#EF4444',
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                html: `
                    <ul style="text-align:left; margin-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonColor: '#F59E0B',
            });
        </script>
    @endif
</body>

</html>
