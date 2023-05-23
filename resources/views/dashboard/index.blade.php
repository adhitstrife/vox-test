@extends('welcome')

@section('content')
    <div class="content px-4 py-4">
        <div class="header mb-4 flex items-center justify-between">
            <div class="title">
                <p class="text-white text-lg font-semibold">Organizers</p>
            </div>
            <div class="add-new-button">
                <a type="button" href="{{ route('dashboard.create') }}" class="bg-gray-200 text-gray-600 text-center font-semibold w-full px-2 py-2 rounded-md">
                    Add New
                </a>
            </div>
        </div>
        <div class="card w-full h-auto bg-white overflow-x-auto">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-3 pb-3 text-slate-400 dark:text-slate-200 text-left">Id</th>
                        <th class="border-b dark:border-slate-600 font-medium p-4 px-0 pt-3 text-slate-400 dark:text-slate-200 text-left">Name</th>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-3 pb-3 text-slate-400 dark:text-slate-200 text-left">image</th>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-3 pb-3 text-slate-400 dark:text-slate-200 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $data->id }}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ $data->organizerName }}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400">
                                <img class="w-10 h-10" src="{{ $data->imageLocation }}" alt="" srcset="">
                            </td>
                            <td>
                                <div class="button">
                                    <div class="edit-button my-2">
                                        <a type="button" href="{{ route('dashboard.edit', $data->id) }}" class="bg-blue-400 text-white text-center font-semibold w-full px-2 py-2 rounded-md">
                                            Edit
                                        </a>
                                    </div>
                                    <div class="delete-button my-2">
                                        <form action="{{ route('dashboard.destroy', $data->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="bg-red-400 text-white text-center font-semibold w-full px-2 py-2 rounded-md">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="link flex justify-between px-2 mt-4">
            @if (isset($paginationLinks->previous))
                <div class="previous-button">
                    <a type="button" href="{{ route('dashboard.index', ['url' => $paginationLinks->previous]) }}" class="bg-gray-200 text-gray-600 text-center font-semibold w-full px-2 py-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                    </a>
                </div>
            @endif
            @if (isset($paginationLinks->next))
                <div class="next-button">
                    <a type="button" href="{{ route('dashboard.index', ['url' => $paginationLinks->next]) }}" class="bg-gray-200 text-gray-600 text-center font-semibold w-full px-2 py-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection