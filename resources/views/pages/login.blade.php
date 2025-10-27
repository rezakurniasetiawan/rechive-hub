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
</head>
<!-- END: Head -->

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="ReChive Hub" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
                    <span class="text-white text-lg ml-3"> ReChive<span class="font-medium">Hub</span> </span>
                </a>
                <div class="my-auto">
                    <img alt="ReChive Hub" class="-intro-x w-1/2 -mt-16"
                        src="{{ asset('dist/images/illustration.svg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        Masuk ke ReChive Hub
                        <br>
                        Atur keuangan dan kehidupan bersama.
                    </div>
                    <div class="-intro-x mt-5 text-lg text-white">Kelola anggaran, aktivitas, dan catatan penting dalam
                        satu tempat.</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->

            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Sign In
                    </h2>
                    <form action="{{ route('auth.actionlogin') }}" method="post">
                        @csrf
                        <div class="intro-x mt-8">
                            <input type="text" name="email"
                                class="intro-x login__input input input--lg border border-gray-300 block"
                                placeholder="Email" value="admin@gmail.com">
                            <input type="password" name="password"
                                class="intro-x login__input input input--lg border border-gray-300 block mt-4"
                                placeholder="Password" value="password">
                        </div>
                        <div class="intro-x flex text-gray-700 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                                <input type="checkbox" class="input border mr-2" id="remember-me">
                                <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                            </div>
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button class="button button--lg w-full text-white bg-theme-1">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
    <!-- BEGIN: JS Assets-->
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <!-- END: JS Assets-->
</body>

</html>
