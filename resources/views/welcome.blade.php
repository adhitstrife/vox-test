<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite('resources/css/app.css')
    </head>
    <body class="content bg-blue-400">
        <div class="navbar mb-16">
            @if (Session::has('user'))
                <div class="navbar h-14 flex justify-around items-center w-full bg-white shadow-lg">
                    <div class="menu-left">
                        <div class="logo px-4">
                            <p>Some Logo</p>
                        </div>
                    </div>
                    <div class="links flex">
                        <div class="organizers mx-2">
                            <a href="">Organizers</a>
                        </div>
                        <div class="organizers mx-2">
                            <a href="{{ route('event.index') }}">Sport</a>
                        </div>
                        <div class="organizers mx-2">
                            <a href="">Users</a>
                        </div>
                    </div>
                    <div class="menu-right">
                        <div class="links px-4">
                            <div class="organizers mx-2">
                                <a href="{{ route('profile.edit', json_decode(Session::get('user'))->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="navbar h-14 flex justify-between items-center w-full bg-white shadow-lg">
                    
                    <div class="logo px-4">
                        <p>Some Logo</p>
                    </div>
                    <div class="button px-4">
                        Login
                    </div>
                </div>
            @endif
        </div>
        @yield('content')

        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        @yield('script')
    </body>
</html>
