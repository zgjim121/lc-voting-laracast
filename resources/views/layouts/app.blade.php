<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laracast Voting</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Open+Sans:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-gray-background text-gray-900 text-sm">
<header class="flex items-center justify-between px-8 py-4">
    <a href=""><img src="{{ asset('img/logo-dark.svg') }}" alt="logo"></a>
    <div class="flex items-center">
        @if (Route::has('login'))
            <div class="px-6 py-4">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-700 underline">
                        Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="ml-4 text-sm text-gray-700 underline">
                            Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <a href="">
            <img src="https://i.pravatar.cc/" alt="avatar" class="w-10 h-10 rounded-full">
        </a>
    </div>
</header>
<main class="container mx-auto max-w-custom flex">
    <div class="w-70 mr-5">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos esse est eveniet excepturi harum itaque maiores. A
        consectetur consequatur cum cumque deserunt distinctio, dolorem eligendi illo ipsam modi molestiae mollitia
        obcaecati, officia possimus provident quia quis quisquam recusandae sit suscipit velit, veniam vitae voluptatem!
        Excepturi ipsa ipsam obcaecati officia quas quo sapiente. Dolor dolorem doloribus eos est ex fugit iste itaque
        magni maxime odio omnis pariatur quasi qui, repudiandae velit veritatis voluptas voluptates. Fugiat laudantium
        modi saepe sapiente. Ab cum dolores quia! Aliquid aperiam architecto culpa deserunt dolorem, doloremque
        explicabo fugiat illo ipsum itaque praesentium quasi recusandae saepe tempora, vero.
    </div>
    <div class="w-175">
        <nav class="flex items-center justify-between test-xs">
            <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
                <li><a href="" class="border-b-4 pb-3 border-blue">All Ideas (87)</a></li>
                <li><a href="" class="text-gray-400 transition duration-150 ease-in border-b-4 pb-3 hover:border-blue">
                        Considering (6)</a></li>
                <li><a href="" class="text-gray-400 transition duration-150 ease-in border-b-4 pb-3 hover:border-blue">
                        Closed (55)</a></li>
            </ul>

            <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
                <li><a href="" class="text-gray-400 transition duration-150 ease-in border-b-4 pb-3 hover:border-blue">
                        Implemented (10)</a></li>
                <li><a href="" class="text-gray-400 transition duration-150 ease-in border-b-4 pb-3 hover:border-blue">
                        Closed (55)</a></li>
            </ul>
        </nav>
        <div class="mt-8">
            {{ $slot  }}
        </div>
    </div>
</main>
</body>
</html>
