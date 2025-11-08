<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ReChive Hub — Personal Life & Finance Dashboard</title>
    <meta name="theme-color" content="#4F46E5" />
    <link href="{{ asset('dist/images/rechive-logo.svg') }}" rel="shortcut icon" />
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
</head>

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">

            <!-- Bagian kiri -->
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
                        <br> Atur keuangan dan kehidupan bersama sampai tua.
                    </div>
                    <div class="-intro-x mt-5 text-lg text-white">
                        Kelola anggaran, aktivitas, dan catatan penting dalam satu tempat.
                    </div>
                </div>
            </div>

            <!-- Bagian kanan -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Sign In</h2>

                    <form id="login-form" action="{{ route('auth.actionlogin') }}" method="post">
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

                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left space-y-3">
                            <button type="submit" class="button button--lg w-full text-white bg-theme-1">
                                Login
                            </button>

                            <!-- Tombol Login dengan Sidik Jari -->
                            <button type="button" id="fingerprint-login"
                                class="button button--lg w-full border border-theme-1 text-theme-1 hover:bg-theme-1 hover:text-white transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-2 align-middle"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 11c.943 0 1.853.244 2.647.685a1 1 0 001.35-1.48A7 7 0 105 12a1 1 0 00-2 0A9 9 0 1112 21a1 1 0 100-2 7 7 0 01-7-7 1 1 0 112 0 5 5 0 005 5z" />
                                </svg>
                                Login dengan Sidik Jari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script>
        const fingerprintBtn = document.getElementById('fingerprint-login');
        const loginForm = document.getElementById('login-form');

        fingerprintBtn.addEventListener('click', async () => {
            const res = await fetch('/webauthn/login-challenge');
            const {
                challenge
            } = await res.json();

            const publicKey = {
                challenge: Uint8Array.from(atob(challenge), c => c.charCodeAt(0)),
                timeout: 60000,
                userVerification: "required",
            };

            const assertion = await navigator.credentials.get({
                publicKey
            });

            const result = await fetch('/webauthn/verify-login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: assertion.id,
                    rawId: btoa(String.fromCharCode(...new Uint8Array(assertion.rawId))),
                })
            });
            const data = await result.json();
            if (data.success) {
                window.location.href = '/dashboard';
            } else {
                alert('Login gagal: ' + data.message);
            }
        });
    </script>
</body>

</html>
