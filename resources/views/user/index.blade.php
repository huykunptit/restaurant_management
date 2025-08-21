@extends('layout.app')

@php $pagename = "User" @endphp

@section('title')
    Tất cả người dùng
@endsection

@section('content')
<div class="p-10">

    {{-- Page Name --}}
    <p class="text-3xl font-bold mb-6">Tất cả người dùng</p>

    {{-- Bread Crumb --}}
    <div class="flex items-center text-sm mb-8">
        <a href="{{ route('home.' . auth()->user()->role->name) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <p>Tất cả người dùng</p>
    </div>

    {{-- Thêm mới Button --}}
    <a href="{{ route('user.create') }}" class="inline-block mb-4">
        <button class="bg-green-800 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300">
            Thêm mới
        </button>
    </a>

    {{-- User Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Họ tên</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Địa chỉ email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Vai trò</th>
                    <th class="px-6 py-3 text-center text-sm font-medium">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                @foreach ($users as $user)
                <tr>
                    <td class="px-6 py-4">{{ $user->first_name .' '. $user->last_name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4 capitalize">{{ $user->role->name }}</td>
                    <td class="px-6 py-4 text-center flex justify-center space-x-2">
                        <a href="{{ route('user.edit', $user->id) }}" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-md">Chỉnh sửa</a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-md">Xoá</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
