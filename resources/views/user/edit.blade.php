@extends('welcome')

@section('content')
    <div class="content px-4 py-4">
        <div class="errors mb-8">
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
        </div>
        <div class="header mb-4 flex items-center justify-between">
            <div class="title">
                <p class="text-white text-lg font-semibold">Edit User</p>
            </div>
        </div>
        <div class="card w-full h-auto bg-white rounded-md overflow-x-auto px-2 py-4">
            <form action="{{ route('profile.update', $data->id) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-8 flex items-center bg-gray-100 ">
                    <input class="bg-gray-100 py-4 px-4 w-full rounded-md outline-none" type="text" name="firstName" placeholder="Event Name" value="{{ $data->firstName }}" autocomplete="off" required>
                </div>
                <div class="mb-8 flex items-center bg-gray-100 ">
                    <input class="bg-gray-100 py-4 px-4 w-full rounded-md outline-none" type="text" name="lastName" placeholder="Event Type" value="{{ $data->lastName }}" autocomplete="off" required>
                </div>
                <div class="mb-8 flex items-center bg-gray-100 ">
                    <input class="bg-gray-100 py-4 px-4 w-full rounded-md outline-none" type="email" name="email" placeholder="Event Date" value="{{ $data->email }}" autocomplete="off" required>
                </div>
                <div class="buttons mb-4">
                    <div class="signIn mb-2">
                        <button type="submit" class="bg-blue-400 text-white font-semibold w-full py-2 rounded-md">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="content px-4 py-4">
        <div class="header mb-4 flex items-center justify-between">
            <div class="title">
                <p class="text-white text-lg font-semibold">Edit Password</p>
            </div>
        </div>
        <div class="card w-full h-auto bg-white rounded-md overflow-x-auto px-2 py-4">
            <form action="{{ route('users.password', $data->id) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-8 flex items-center bg-gray-100 ">
                    <input class="bg-gray-100 py-4 px-4 w-full rounded-md outline-none" type="password" name="oldPassword" placeholder="Old Password" autocomplete="off" required>
                </div>
                <div class="mb-8 flex items-center bg-gray-100 ">
                    <input class="bg-gray-100 py-4 px-4 w-full rounded-md outline-none" type="password" name="newPassword" placeholder="New Password" autocomplete="off" required>
                </div>
                <div class="mb-8 flex items-center bg-gray-100 ">
                    <input class="bg-gray-100 py-4 px-4 w-full rounded-md outline-none" type="password" name="repeatPassword" placeholder="Repeat Password" autocomplete="off" required>
                </div>
                <div class="buttons mb-4">
                    <div class="signIn mb-2">
                        <button type="submit" class="bg-blue-400 text-white font-semibold w-full py-2 rounded-md">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="delete-button px-4 my-4">
        <div class="edit-button my-2">
            <a type="button" href="{{ route('users.logout') }}" class="bg-gray-200 text-gray-600 text-center font-semibold w-full px-2 py-2 rounded-md">
                Logout
            </a>
        </div>
        <form action="{{ route('profile.destroy', $data->id) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="bg-red-400 text-white text-center font-semibold w-full px-2 py-2 rounded-md">
                Delete Account
            </button>
        </form>
    </div>
@endsection