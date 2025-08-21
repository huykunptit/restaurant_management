@extends('layout.app')

@php $pagename = "User" @endphp

@section('title')

    Edit User Account: {{ $user->first_name .' '. $user->last_name }}

@endsection

@section('content')

    <div class="p-10">

        {{-- Page Name --}}
        <p class="text-3xl font-bold">Edit User Account: {{ $user->first_name .' '. $user->last_name }}</p>

        {{-- Bread Crumb --}}
        <div class="flex flex-row items-center text-sm my-10">
            <a href="{{ route('home.' . auth()->user()->role->name ) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('user.index') }}" class="font-bold hover:text-blue-800">Tất cả người dùng</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <p>Edit User Account</p>
        </div>

        {{-- Form Description --}}
        <p class="text-gray-500 mb-10">Make changes to the form below to edit the user account</p>
        
        <form action="{{ route('user.update', $user->id) }}" method="post">

            @csrf
            @method('put')

            {{-- All Grid --}}
            <div class="lg:w-1/2 grid grid-cols-2 gap-x-5 gap-y-8 mb-20">

                {{-- User Role --}}
                <div class="col-span-2 grid grid-cols-2 gap-x-5">

                    <p class="col-span-2 font-bold">Vai trò</p>
                    
                    <div class="col-span-1 mt-3">

                        <select name="role" id="role" class="w-full p-1 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg capitalize" required>

                            @foreach ($roles as $role)
                                <option {{ ($user->role->id) == ($role->id) ? 'selected' : '' }}  value="{{ $role->id }}" class="capitalize">{{ $role->name }}</option>
                            @endforeach

                        </select>

                    </div>
        
                    @error('role')
                        {{ $message }}
                    @enderror
                </div>

                {{-- First Name --}}
                <div class="col-span-1">
                    <p class="font-bold">Họ</p>

                    <input type="text" name="firstName" value="{{ $user->first_name }}" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>
        
                    @error('firstName')
                        {{ $message }}
                    @enderror
                </div>

                {{-- Last Name --}}
                <div class="col-span-1">
                    <p class="font-bold">Tên</p>

                    <input type="text" name="lastName" value="{{ $user->last_name }}" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>
        
                    @error('lastName')
                        {{ $message }}
                    @enderror
                </div>

                {{-- Địa chỉ email --}}
                <div class="col-span-1">
                    <p class="font-bold">Địa chỉ email</p>

                    <input type="text" name="email" value="{{ $user->email }}" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>
        
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>

                {{-- Password --}}
                <div class="col-span-1">
                    <p class="font-bold">Mật khẩu</p>

                    <input type="password" name="password" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 bg-gray-300 focus:bg-white rounded-lg">
        
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>

                <button type="submit" class="border-3 hover:border-green-700 border-green-800 hover:bg-green-700 bg-green-800 text-white py-4 rounded-lg font-bold transition-all duration-500 transform hover:scale-105">
                    <p>Xác nhận Chỉnh sửa</p>
                </button>

                <a href="{{ route('user.index') }}" class="border-3 hover:border-red-700 border-red-800 hover:bg-red-700 bg-red-800 text-white py-4 rounded-lg text-center font-bold transition-all duration-500 transform hover:scale-105">
                    Huỷ
                </a>

            </div>

        </form>

    </div>




@endsection