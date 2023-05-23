@extends('welcome')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger px-8">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="mt-4">
                        <div class="text-center bg-red-400 rounded-sm text-white">
                            {{ $error }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="content px-8 py-16">
        <div class="h-auto p-4 border bg-white rounded-md shadow-md">
            <div class="title mb-8">
                <p class="text-center text-lg font-semibold">Login</p>
            </div>
            <form action="{{ route('login.store') }}" method="post">
                @csrf
                <div class="mb-6 flex items-center bg-gray-100 ">
                    <div class="icon px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <input class="bg-gray-100 py-4 pr-4 w-full rounded-md outline-none" type="email" name="email" placeholder="email" autocomplete="off" required>
                </div>
                <div class="mb-6 flex items-center bg-gray-100 ">
                    <div class="icon px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                    <input class="bg-gray-100 py-4 pr-4 w-full rounded-md outline-none" type="password" name="password" placeholder="password" autocomplete="off" required>
                </div>
                <div class="buttons mb-4">
                    <div class="signIn mb-2">
                        <button type="submit" class="bg-blue-400 text-white font-semibold w-full py-2 rounded-md">Sign In</button>
                    </div>
                    <div class="singUp w-full">
                        <a type="button" href="{{ route('users.create') }}" class="bg-gray-200 text-gray-600 text-center font-semibold w-full py-2 rounded-md">Sing Up</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection