@extends('layout.app')

@php $pagename = "Menu" @endphp

@section('title')

    @isset($pagename) {{ $pagename }} @endisset

@endsection

@section('content')

    @php
        $i = 0;
    @endphp

    <div class="p-10">

        {{-- Page Name --}}
        <p class="text-3xl font-bold">@isset($pagename) {{ $pagename }} @endisset</p>

        {{-- Bread Crumb --}}
        <div class="flex flex-row items-center text-sm my-10">
            <a href="{{ route('home.' . auth()->user()->role->name ) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <p>Menu</p>
        </div>
        
        {{-- Filter Buttons --}}
        <div class="space-x-3 flex flex-row text-center overflow-auto whitespace-nowrap filterButtons">

            <div id="foodsButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-900 bg-green-800 text-white hover:text-white font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                </svg>
                <p>Đồ ăn</p>
            </div>

            <div id="drinksButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                <p>Đồ uống</p>
            </div>

        </div>

        <a href="{{ route('menu.create') }}">
            <div class="my-10 flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-40 rounded-md cursor-pointer transform hover:scale-105 transition-all duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                </svg>
                <p>Thêm mới</p>
            </div>
        </a>
        
        <div class="w-full my-10">
            
            {{-- Foods Content --}}
            <div id="foodsContent">

                @isset($foods)
                
                    {{-- All Content Grids --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5">
                            
                        @foreach ($foods as $food)
                            
                            {{-- One Table Grid --}}
                            <div class="my-5 w-full group">

                                {{-- Menu Item Image --}}
                                @if ($food->thumbnail == null)

                                    <div class="relative bg-black w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                        <img class="w-full h-auto" src="{{ asset('img/noimg.png') }}">
                                        
                                        {{-- Tags --}}
                                        <div class="absolute right-1 top-1 flex flex-row space-x-2">
        
                                            {{-- Check if Menu is Disabled --}}
                                            @if ($food->disable == "yes")
                                                <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                    <p>Disabled</p>
                                                </div>
                                            @endif

                                        </div>

                                    </div>

                                @else

                                    <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                        
                                        <img class="w-full h-auto" src="{{ asset('images/'.$food->thumbnail) }}">
                                        
                                        {{-- Tags --}}
                                        <div class="absolute right-1 top-1 flex flex-row space-x-2">
        
                                            {{-- Check if Menu is Disabled --}}
                                            @if ($food->disable == "yes")
                                                <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                    <p>Disabled</p>
                                                </div>
                                            @endif

                                        </div>

                                    </div>

                                @endif

                                {{-- Menu Item Name and Price --}}
                                <div class="flex flex-row items-center justify-between font-bold my-4 mx-2 space-x-2">
                                    <p class="whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">{{ $food->name }}</p>
                                    <p class="whitespace-nowrap"> {{ number_format($food->menuOption->first()->cost, 0) }} VNĐ</p>
                                                                    <p class="px-6 py-4">
                                    @if ($food->pre_order)
                                        <span class="text-green-600 font-bold">Đặt trước</span>
                                    @else
                                        <span class="text-red-600 font-bold"></span>
                                    @endif
</p>
                                </div>
                    
                                {{-- Buttons --}}
                                <div class="w-full flex flex-row items-center justify-between gap-x-1.5 mt-2">

                                    {{-- Edit Button --}}
                                    <form action="{{ route('menu.edit', $food->id) }}" method="GET" class="w-1/2">
                                        @csrf
        
                                        <button type="submit" class="w-full border-2 border-green-800 bg-green-800 text-white px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Chỉnh sửa</button>
                                    </form>

                                    @if ($food->disable == 'no')

                                        <form action="{{ route('menu.disable', $food->id) }}" method="POST" class="w-1/4">

                                            @csrf
                                            @method('put')

                                            {{-- Disable --}}
                                            <button type="submit" class="w-full flex flex-row items-center justify-center font-bold p-2 border-2 border-red-700 bg-red-700 text-white px-2 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>

                                        </form>

                                    @else

                                        <form action="{{ route('menu.enable', $food->id) }}" method="POST" class="w-1/4">
                                            @csrf
                                            @method('put')

                                            {{-- Enable --}}
                                            <button type="submit" class="w-full flex flex-row items-center justify-center font-bold p-2 border-2 border-green-700 bg-green-700 text-white px-2 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>

                                        </form>

                                    @endif

                                    <button onclick="delete{{ $food->id }}()" class="w-1/4 flex flex-row items-center justify-center font-bold p-2 border-2 border-black bg-black text-white px-2 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    
                                    {{-- Modal --}}
                                    <div id="modal{{ $food->id }}" class="hidden fixed z-10 inset-0 w-full h-full overflow-auto pt-20" style="background: rgba(0,0,0,0.5);">
                                            
                                        <div id="modalBox{{ $food->id }}" class="bg-white w-3/4 lg:w-1/3 mx-auto p-10 rounded-lg text-center animate__animated animate__bounceInDown shadow-2xl">

                                            {{-- Title --}}
                                            <p class="text-3xl font-bold">Xác nhận Deletion</p>

                                            {{-- Text --}}
                                            <p class="my-10">Are you sure you want to delete this menu item?</p>

                                            {{-- Button --}}
                                            <div class="flex flex-row items-center justify-center gap-5">

                                                <form action="{{ route('menu.destroy', $food->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
        
                                                    {{-- Disable --}}
                                                    <button type="submit" class="bg-green-800 text-white px-10 py-3 rounded-md">Yes</button>

                                                </form>

                                                <div href="" onclick="cancel{{ $food->id }}()" class="bg-red-800 text-white px-10 py-3 rounded-md cursor-pointer">Huỷ</div>
                                            </div>
                                        </div>  

                                    </div>
                                    
                                    {{-- Modal Script (NOTE: Don't Move) --}}
                                    <script>

                                        // Xoá Button
                                        function delete{{ $food->id }}(){

                                            const modal{{ $food->id }} =  document.querySelector('#modal{{ $food->id }}');
                                            const modalBox{{ $food->id }} =  document.querySelector('#modalBox{{ $food->id }}');

                                            if (modal{{ $food->id }}.classList.contains('hidden')){
                                                
                                                modal{{ $food->id }}.classList.remove('hidden');

                                            }

                                            if (modalBox{{ $food->id }}.classList.contains('animate__bounceOutUp')){
                                                
                                                modalBox{{ $food->id }}.classList.remove('animate__bounceOutUp');
                                                modalBox{{ $food->id }}.classList.add('animate__bounceInDown');

                                            }
                                        }

                                        // Cancel Button
                                        function cancel{{ $food->id }}(){

                                            const modal{{ $food->id }} =  document.querySelector('#modal{{ $food->id }}');
                                            const modalBox{{ $food->id }} =  document.querySelector('#modalBox{{ $food->id }}');

                                            if (modalBox{{ $food->id }}.classList.contains('animate__bounceInDown')){
                                                
                                                modalBox{{ $food->id }}.classList.remove('animate__bounceInDown');
                                                modalBox{{ $food->id }}.classList.add('animate__bounceOutUp');

                                            }
                                            
                                            setTimeout(function () {
                                                modal{{ $food->id }}.classList.add('hidden');
                                            }, 800);

                                        }

                                        const modal{{ $food->id }} =  document.querySelector('#modal{{ $food->id }}');
                                        const modalBox{{ $food->id }} =  document.querySelector('#modalBox{{ $food->id }}');
                                        
                                        window.addEventListener("click", function(event) {

                                            if (event.target == modal{{ $food->id }}) {

                                                if (modalBox{{ $food->id }}.classList.contains('animate__bounceInDown')){
                                                
                                                    modalBox{{ $food->id }}.classList.remove('animate__bounceInDown');
                                                    modalBox{{ $food->id }}.classList.add('animate__bounceOutUp');

                                                }
                                                
                                                setTimeout(function () {
                                                    modal{{ $food->id }}.classList.add('hidden');
                                                }, 800);

                                            }
                                        });

                                    </script>

                                </div>
                    
                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="sm:w-1/2 mx-auto -mt-14">
                        <img src="{{ asset('img/no_food.svg') }}" class="sm:w-2/3 mx-auto"> 
                        <p class="font-extrabold text-4xl text-center mt-4">No Food Found</p>
                        <p class="font-extrabold text-sm text-center mt-2">If you are an Admin or Kitchen Staff, please add a new Food Item.</p>
                    </div>

                @endisset

            </div>

            <div id="drinksContent" class="hidden">

                @isset($drinks)
                    
                    {{-- All Content Grids --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5">

                        @foreach ($drinks as $drink)

                            {{-- One Table Grid --}}
                            <div class="my-5 w-full group">

                                {{-- Menu Item Image --}}
                                @if ($drink->thumbnail == null)

                                    <div class="relative bg-black w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                        <img class="w-full h-auto" src="{{ asset('img/noimg.png') }}">
                                        
                                        {{-- Tags --}}
                                        <div class="absolute right-1 top-1 flex flex-row space-x-2">
        
                                            {{-- Check if Menu is Disabled --}}
                                            @if ($drink->disable == "yes")
                                                <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                    <p>Disabled</p>
                                                </div>
                                            @endif

                                        </div>

                                    </div>

                                @else

                                    <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                        
                                        <img class="w-full h-auto" src="{{ asset('images/'.$drink->thumbnail) }}">
                                        
                                        {{-- Tags --}}
                                        <div class="absolute right-1 top-1 flex flex-row space-x-2">
        
                                            {{-- Check if Menu is Disabled --}}
                                            @if ($drink->disable == "yes")
                                                <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                    <p>Disabled</p>
                                                </div>
                                            @endif

                                        </div>

                                    </div>

                                @endif

                                {{-- Menu Item Name and Price --}}
                                <div class="flex flex-row items-center justify-between space-x-2 font-bold my-4 mx-2">
                                    <p class="whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">{{ $drink->name }}</p>
                                    <p class="whitespace-nowrap">{{ number_format($drink->menuOption->first()->cost, 0) }} VNĐ</p>
                                </div>
                    
                                {{-- Buttons --}}
                                <div class="w-full flex flex-row items-center justify-between space-x-1.5 mt-2">

                                    {{-- Edit Button --}}
                                    <form action="{{ route('menu.edit', $drink->id) }}" method="GET" class="w-1/2">
                                        @csrf
        
                                        <button type="submit" class="w-full border-2 border-green-800 bg-green-800 text-white px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Chỉnh sửa</button>
                                    </form>

                                    @if ($drink->disable == 'no')

                                        <form action="{{ route('menu.disable', $drink->id) }}" method="POST" class="w-1/4">
                                            @csrf
                                            @method('put')

                                            {{-- Disable --}}
                                            <button type="submit" class="w-full flex flex-row items-center justify-center font-bold p-2 border-2 border-red-700 bg-red-700 text-white px-2 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>

                                        </form>

                                    @else

                                        <form action="{{ route('menu.enable', $drink->id) }}" method="POST" class="w-1/4">
                                            @csrf
                                            @method('put')

                                            {{-- Enable --}}
                                            <button type="submit" class="w-full flex flex-row items-center justify-center font-bold p-2 border-2 border-green-700 bg-green-700 text-white px-2 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>

                                        </form>

                                    @endif
                                    
                                    <form action="{{ route('menu.destroy', $drink->id) }}" method="POST" class="w-1/4">

                                        @csrf
                                        @method('DELETE')
        
                                        {{-- Xoá --}}
                                        <button type="submit" class="w-full flex flex-row items-center justify-center font-bold p-2 border-2 border-black bg-black text-white px-2 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                    </form>

                                </div>
                    
                            </div>
                        
                        @endforeach

                    </div>

                @else

                    <div class="sm:w-1/2 mx-auto -mt-24">
                        <img src="{{ asset('img/no_drink.svg') }}" class="sm:w-2/3 mx-auto"> 
                        <p class="font-extrabold text-4xl text-center mt-4">No Drinks Found</p>
                        <p class="font-extrabold text-sm text-center mt-2">If you are an Admin or Kitchen Staff, please add a new Drink Item.</p>
                    </div>

                @endisset

            </div>
            
        </div>

    </div>

    {{-- JavaScript --}}
    <script src="{{ asset('js/menu_index.js') }}" ></script>

@endsection