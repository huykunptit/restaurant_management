@extends('layout.app')

@php $pagename = "Home" @endphp

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
            <p>Danh sách order</p>
        </div>
        
        {{-- Filter Buttons --}}
        <div class="space-x-3 flex flex-row text-center overflow-auto whitespace-nowrap filterButtons">

            <div id="allButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-900 bg-green-800 text-white hover:text-white font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <p>Tất cả</p>
            </div>

            <div id="uncompletedButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-56 rounded-full cursor-pointer transition-all duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
                <p>Chưa giao món</p>
            </div>

            <div id="completedButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-72 rounded-full cursor-pointer transition-all duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Đã giao món và chưa thanh toán</p>
            </div>

        </div>
        
        
        <div class="w-full my-10">
            
            {{-- All Tables --}}
            <div id="allContent">

                @isset($filledTables)

                    {{-- All Content Grids --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5">

                        @foreach ($filledTables as $filledTable)

                            {{-- One Table Grid --}}
                            <div class="my-5 w-full">

                                <form action="{{ route('order.show', $filledTable->id) }}" method="GET">
                                    @csrf

                                    {{-- Graphics --}}
                                    <button type="submit" class="relative patternOne border-4 border-green-800 w-full h-44 rounded-lg transform hover:scale-105 transition-all duration-500">
                                        
                                        {{-- Tags --}}
                                        <div class="absolute right-1 top-1 flex flex-row space-x-2">

                                            {{-- Check if all 'Orders' is Completed --}}
                                            @if ($filledTable->order->every('completion_status', 'yes'))
                                                <div class="px-2 py-1 bg-green-600 text-white text-xs rounded-full">
                                                    <p>Đã giao món</p>
                                                </div>
                                            @else
                                                <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                    <p>Chưa giao món</p>
                                                </div>
                                            @endif

                                            {{-- Check if all 'Orders' is Paid --}}
                                            @if ($filledTable->order->every('payment_status', 'yes'))
                                                <div class="px-2 py-1 bg-green-600 text-white text-xs rounded-full">
                                                    <p>Đã thanh toán</p>
                                                </div>
                                            @else
                                                <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                    <p>Unpaid</p>
                                                </div>
                                            @endif

                                        </div>
                        
                                        {{-- Table Name --}}
                                        <div class="absolute flex flex-row items-center justify-center top-0 right-0 left-0 bottom-0">
                                            <p class="my-auto text-center text-4xl font-semibold filter drop-shadow-lg">{{ $filledTable->first_name . " " . $filledTable->last_name }}</p>
                                        </div>

                                        @php $total = 0 @endphp

                                        @foreach ( $filledTable->order as $order)
                                            @if ($order->payment_status == "no")
                                                <div class="hidden">
                                                    {{ $total +=  $order->menuOption->cost * $order->quantity}}
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                        <div class="absolute bottom-0 left-0 py-1.5 bg-green-800 text-white w-full">
                                            @if ($filledTable->order->every('payment_status', 'yes'))
                                                <p class="font-semibold text-center tracking-widest">Đã thanh toán</p>
                                            @else
                                                <p class="font-semibold text-center tracking-widest">{{ number_format($total,0)}} VNĐ</p>
                                            @endif
                                        </div>
                        
                                    </button>

                                </form>
                    
                                {{-- Buttons --}}
                                <div class="w-full flex flex-row items-center justify-between space-x-2 mt-2">

                                    {{-- Check if all 'Orders' is Completed --}}
                                    @if ($filledTable->order->every('completion_status', 'yes'))
                                        <button disabled class="w-1/2 border-2 border-gray-300 bg-gray-300 text-gray-500 py-1 text-center rounded-full cursor-not-allowed">Đã giao món</button>
                                    @else
                                        <form action="{{ route('order.complete', $filledTable->id) }}" method="POST" class="w-1/2">
                                            @csrf
                                            @method('put')
            
                                            <button type="submit" class="w-full border-2 border-green-800 bg-green-800 text-white px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Complete</button>
                                        </form>
                                    @endif

                                    {{-- Check if all 'Orders' is Paid --}}
                                    @if ($filledTable->order->every('payment_status', 'yes'))
                                        <button disabled class="w-1/2 border-2 border-gray-300 bg-gray-300 text-gray-500 px-5 py-1 text-center rounded-full cursor-not-allowed">Đã thanh toán</button>
                                    @else
                                        <form action="{{ route('order.paid', $filledTable->id) }}" method="POST" class="w-1/2">
                                            @csrf
                                            @method('put')
            
                                            <button type="submit" class="w-full border-2 border-green-800 text-green-800 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Pay</button>
                                        </form>
                                    @endif

                                </div>
                    
                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="sm:w-1/2 mx-auto mt-20">
                        <img src="{{ asset('img/not_found.svg') }}" class="sm:w-2/3 mx-auto"> 
                        <p class="font-extrabold text-4xl text-center mt-4">No Data Found</p>
                        <p class="font-extrabold text-sm text-center mt-2">If you are an admin, please add a user with the role 'Customer'.</p>
                    </div>
                    
                @endisset

            </div>
            
            {{-- Table with Uncompleted Orders --}}
            <div id="uncompletedContent" class="hidden">
                
                {{-- Uncompleted Order Grids --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5">

                    @foreach ($filledTables as $filledTable)

                        {{-- Table with Orders --}}
                        @if(!$filledTable->order->isEmpty())

                            {{-- Uncompleted Orders --}}
                            @if (!$filledTable->order->every('completion_status', 'yes'))
                                
                                @php
                                    $i = 1;
                                @endphp
                                
                                {{-- One Table Grid --}}
                                <div class="my-5 w-full">

                                    <form action="{{ route('order.show', $filledTable->id) }}" method="GET">
                                        @csrf
    
                                        {{-- Graphics --}}
                                        <button type="submit" class="relative patternOne border-4 border-green-800 w-full h-44 rounded-lg transform hover:scale-105 transition-all duration-500">
                                            
                                            {{-- Tags --}}
                                            <div class="absolute right-1 top-1 flex flex-row space-x-2">
    
                                                {{-- Check if all 'Orders' is Completed --}}
                                                @if ($filledTable->order->every('completion_status', 'yes'))
                                                    <div class="px-2 py-1 bg-green-600 text-white text-xs rounded-full">
                                                        <p>Đã giao món</p>
                                                    </div>
                                                @else
                                                    <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                        <p>Chưa giao món</p>
                                                    </div>
                                                @endif
    
                                                {{-- Check if all 'Orders' is Paid --}}
                                                @if ($filledTable->order->every('payment_status', 'yes'))
                                                    <div class="px-2 py-1 bg-green-600 text-white text-xs rounded-full">
                                                        <p>Đã thanh toán</p>
                                                    </div>
                                                @else
                                                    <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                        <p>Unpaid</p>
                                                    </div>
                                                @endif
    
                                            </div>
                            
                                            {{-- Table Name --}}
                                            <div class="absolute flex flex-row items-center justify-center top-0 right-0 left-0 bottom-0">
                                                <p class="my-auto text-center text-4xl font-semibold filter drop-shadow-lg">{{ $filledTable->first_name . " " . $filledTable->last_name }}</p>
                                            </div>
    
                                            @php $total = 0 @endphp
    
                                            @foreach ( $filledTable->order as $order)
                                                @if ($order->payment_status == "no")
                                                    <div class="hidden">
                                                        {{ $total +=  $order->menuOption->cost * $order->quantity}}
                                                    </div>
                                                @endif
                                            @endforeach
                                            
                                            <div class="absolute bottom-0 left-0 py-1.5 bg-green-800 text-white w-full">
                                                @if ($filledTable->order->every('payment_status', 'yes'))
                                                    <p class="font-semibold text-center tracking-widest">Đã thanh toán</p>
                                                @else
                                                    <p class="font-semibold text-center tracking-widest">{{ number_format($total,0)}} VNĐ</p>
                                                @endif
                                            </div>
                            
                                        </button>
    
                                    </form>

                                    {{-- Buttons --}}
                                    <div class="w-full flex flex-row items-center justify-between space-x-2 mt-2">

                                        {{-- Check if all 'Orders' is Completed --}}
                                        @if ($filledTable->order->every('completion_status', 'yes'))
                                            <button disabled class="w-1/2 border-2 border-gray-300 bg-gray-300 text-gray-500 py-1 text-center rounded-full cursor-not-allowed">Đã giao món</button>
                                        @else
                                            <form action="{{ route('order.complete', $filledTable->id) }}" method="POST" class="w-1/2">
                                                @csrf
                                                @method('put')
                
                                                <button type="submit" class="w-full border-2 border-green-800 bg-green-800 text-white px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Complete</button>
                                            </form>
                                        @endif

                                        {{-- Check if all 'Orders' is Paid --}}
                                        @if ($filledTable->order->every('payment_status', 'yes'))
                                            <button disabled class="w-1/2 border-2 border-gray-300 bg-gray-300 text-gray-500 px-5 py-1 text-center rounded-full cursor-not-allowed">Đã thanh toán</button>
                                        @else
                                            <form action="{{ route('order.paid', $filledTable->id) }}" method="POST" class="w-1/2">
                                                @csrf
                                                @method('put')
                
                                                <button type="submit" class="w-full border-2 border-green-800 text-green-800 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Pay</button>
                                            </form>
                                        @endif

                                    </div>

                                </div>
                                
                            @endif
                            
                        @endif
                        
                    @endforeach
                   
                </div>

                @if ($i == 0)

                    <div class="mx-auto mt-5">
                        <img src="{{ asset('img/not_found.svg') }}" class="sm:w-1/4 mx-auto"> 
                        <p class="font-extrabold text-4xl text-center mt-4">Không có đơn nào chưa được giao</p>
                        <p class="font-extrabold text-sm text-center mt-2">No worries, more customer will come.</p>
                    </div>
                         
                @endif

                @php
                    $i = 0;
                @endphp

            </div>

            {{-- Table with Completed Orders --}}
            <div id="completedContent" class="hidden">
                
                {{-- Uncompleted Order Grids --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5">

                    @foreach ($filledTables as $filledTable )

                        {{-- Table with Orders --}}
                        @if(!$filledTable->order->isEmpty())
                            
                            {{-- Completed Orders --}}
                            @if ($filledTable->order->every('completion_status', 'yes'))

                                {{-- Unpaid Orders --}}
                                @if (!$filledTable->order->every('payment_status', 'yes'))

                                    @php
                                        $i = 1;
                                    @endphp

                                    {{-- One Table Grid --}}
                                    <div class="my-5 w-full">

                                        <form action="{{ route('order.show', $filledTable->id) }}" method="GET">
                                            @csrf
        
                                            {{-- Graphics --}}
                                            <button type="submit" class="relative patternOne border-4 border-green-800 w-full h-44 rounded-lg transform hover:scale-105 transition-all duration-500">
                                                
                                                {{-- Tags --}}
                                                <div class="absolute right-1 top-1 flex flex-row space-x-2">
        
                                                    {{-- Check if all 'Orders' is Completed --}}
                                                    @if ($filledTable->order->every('completion_status', 'yes'))
                                                        <div class="px-2 py-1 bg-green-600 text-white text-xs rounded-full">
                                                            <p>Đã giao món</p>
                                                        </div>
                                                    @else
                                                        <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                            <p>Chưa giao món</p>
                                                        </div>
                                                    @endif
        
                                                    {{-- Check if all 'Orders' is Paid --}}
                                                    @if ($filledTable->order->every('payment_status', 'yes'))
                                                        <div class="px-2 py-1 bg-green-600 text-white text-xs rounded-full">
                                                            <p>Đã thanh toán</p>
                                                        </div>
                                                    @else
                                                        <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                            <p>Unpaid</p>
                                                        </div>
                                                    @endif
        
                                                </div>
                                
                                                {{-- Table Name --}}
                                                <div class="absolute flex flex-row items-center justify-center top-0 right-0 left-0 bottom-0">
                                                    <p class="my-auto text-center text-4xl font-semibold filter drop-shadow-lg">{{ $filledTable->first_name . " " . $filledTable->last_name }}</p>
                                                </div>
        
                                                @php $total = 0 @endphp
        
                                                @foreach ( $filledTable->order as $order)
                                                    @if ($order->payment_status == "no")
                                                        <div class="hidden">
                                                            {{ $total +=  $order->menuOption->cost * $order->quantity}}
                                                        </div>
                                                    @endif
                                                @endforeach
                                                
                                                <div class="absolute bottom-0 left-0 py-1.5 bg-green-800 text-white w-full">
                                                    @if ($filledTable->order->every('payment_status', 'yes'))
                                                        <p class="font-semibold text-center tracking-widest">Đã thanh toán</p>
                                                    @else
                                                        <p class="font-semibold text-center tracking-widest">{{ number_format($total,0)}} VNĐ</p>
                                                    @endif
                                                </div>
                                
                                            </button>
        
                                        </form>

                                        {{-- Buttons --}}
                                        <div class="w-full flex flex-row items-center justify-between space-x-2 mt-2">

                                            {{-- Check if all 'Orders' is Completed --}}
                                            @if ($filledTable->order->every('completion_status', 'yes'))
                                                <button disabled class="w-1/2 border-2 border-gray-300 bg-gray-300 text-gray-500 py-1 text-center rounded-full cursor-not-allowed">Đã giao món</button>
                                            @else
                                                <form action="{{ route('order.complete', $filledTable->id) }}" method="POST" class="w-1/2">
                                                    @csrf
                                                    @method('put')
                    
                                                    <button type="submit" class="w-full border-2 border-green-800 bg-green-800 text-white px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Complete</button>
                                                </form>
                                            @endif

                                            {{-- Check if all 'Orders' is Paid --}}
                                            @if ($filledTable->order->every('payment_status', 'yes'))
                                                <button disabled class="w-1/2 border-2 border-gray-300 bg-gray-300 text-gray-500 px-5 py-1 text-center rounded-full cursor-not-allowed">Đã thanh toán</button>
                                            @else
                                                <form action="{{ route('order.paid', $filledTable->id) }}" method="POST" class="w-1/2">
                                                    @csrf
                                                    @method('put')
                    
                                                    <button type="submit" class="w-full border-2 border-green-800 text-green-800 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Pay</button>
                                                </form>
                                            @endif

                                        </div>

                                    </div>

                                @endif

                            @endif
                            
                        @endif
                    
                    @endforeach

                </div>

                @if ($i == 0)

                    <div class="mx-auto mt-5">
                        <img src="{{ asset('img/eating.svg') }}" class="sm:w-1/4 mx-auto"> 
                        <p class="font-extrabold text-4xl text-center mt-4">Không có đơn nào đã giao và đơn chưa thanh toán</p>
                        <p class="font-extrabold text-sm text-center mt-2">Please wait for the customer to finish eating, No rush here.</p>
                    </div>
                         
                @endif

                @php
                    $i = 0;
                @endphp

            </div>
            
        </div>

    </div>

    {{-- JavaScript --}}
    <script src="{{ asset('js/order_index.js') }}" ></script>


@endsection
