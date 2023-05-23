@extends('welcome')

@section('content')
    <div class="content px-4 py-4">
        <div class="header mb-4 flex items-center justify-between">
            <div class="title">
                <p class="text-white text-lg font-semibold">Edit Organizers</p>
            </div>
        </div>
        <div class="card w-full h-auto bg-white rounded-md overflow-x-auto px-2 py-4">
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
            <form action="{{ route('dashboard.update', $data->id) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-8 flex items-center bg-gray-100 ">
                    <input class="bg-gray-100 py-4 px-4 w-full rounded-md outline-none" type="text" name="organizerName" placeholder="Organizer Name" value="{{ $data->organizerName }}" autocomplete="off" required>
                </div>
                <div class="image">
                    <div class="mb-6 flex items-center bg-gray-100 ">
                        <input class="bg-gray-100 py-4 px-4 w-full rounded-md outline-none" type="text" name="imageLocation" value="{{ $data->imageLocation }}" placeholder="Image Url" autocomplete="off">
                    </div>
                </div>
                <div class="buttons mb-4">
                    <div class="signIn mb-2">
                        <button type="submit" class="bg-blue-400 text-white font-semibold w-full py-2 rounded-md">Sign In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection