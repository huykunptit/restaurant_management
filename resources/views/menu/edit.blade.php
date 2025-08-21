@extends('layout.app')

@php $pagename = "Menu" @endphp

@section('title')

Edit Menu Item

@endsection

@section('content')

<div class="p-10">

    {{-- Page Name --}}
    <p class="text-3xl font-bold">Edit Menu Item: {{ $menu->name }}</p>

    {{-- Bread Crumb --}}
    <div class="flex flex-row items-center text-sm my-10">
        <a href="{{ route('home.' . auth()->user()->role->name ) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('menu.index') }}" class="font-bold hover:text-blue-800">Menu</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <p>Edit Menu Item</p>
    </div>

    <p class="text-gray-500 mb-10">Make changes in the form below to edit the menu item</p>

    <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('put')

        {{-- All Grid --}}
        <div class="lg:w-1/2 grid grid-cols-2 gap-x-5 gap-y-8 mb-20">

            {{-- Danh mục --}}
            <div class="col-span-2">
                <p class="font-bold">Danh mục</p>

                <div class="flex flex-row items-center space-x-3 mt-3">
                    @foreach ($categories as $category)

                    <div class="icheck-material-teal capitalize">
                        <input type="radio" id="{{ $category->id }}" name="category" value="{{ $category->id }}"
                            @if ($menu->category_id == $category->id )
                        checked
                        @endif
                        required />
                        <label for="{{ $category->id }}">{{ $category->name }}</label>
                    </div>

                    @endforeach
                </div>

                @error('category')
                {{ $message }}
                @enderror
            </div>

            {{-- Name --}}
            <div class="col-span-1">
                <p class="font-bold">Tên</p>

                <input type="text" name="name" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" value="{{ $menu->name }}" required>

                @error('name')
                {{ $message }}
                @enderror
            </div>

            {{-- Image --}}
            <div class="col-span-1">
                <p class="font-bold">Image</p>

                <label class="w-full mt-3 flex flex-row items-center border-3 border-green-800 rounded-lg p-0.5">
                    <div class="bg-green-800 text-white px-4 py-1.5 rounded-lg">
                        <p>Lựa chọn file</p>
                    </div>
                    <p id="fileName" class="ml-4 w-20"></p>
                    <input id="upload-input" name="image" class="hidden" placeholder="Select a file" type="file" value="{{ old('image') }}" accept="image/*" onchange="getFileName()">
                </label>

                <script>
                    function getFileName() {
                        var x = document.getElementById('upload-input')
                        x.style.visibility = 'collapse'
                        document.getElementById('fileName').innerHTML = x.value.split('\\').pop()
                    }
                </script>

                @error('image')
                {{ $message }}
                @enderror
            </div>

            {{-- Menu Options --}}
            <div class="col-span-2 w-full" id="dynamicAddRemove">
                <p class="font-bold mb-3">Lựa chọn chi tiết</p>

                @foreach ($menuOptions as $menuOption )

                @if ($loop->first)

                {{-- First Row --}}
                <div class="flex flex-row items-end space-x-4 mb-3 w-full">

                    <div class="w-full">
                        <p class="text-sm font-bold">Option Tên</p>
                        <input type="text" name="optionName[0]" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" maxlength="16" value="{{ $menuOption->name }}" required>
                        @error('optionName.0')
                        {{ $message }}
                        @enderror
                    </div>

                    <div class="w-full">
                        <p class="text-sm font-bold">Price (VNĐ)</p>
                        <input type="number" min="1" step="any" name="optionPrice[0]" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" value="{{ $menuOption->cost }}" required>

                        @error('optionPrice.0')
                        {{ $message }}
                        @enderror
                    </div>

                    <button type="button" name="add" id="dynamic-ar">
                        <div class="bg-green-800 hover:bg-green-700 text-white text-center rounded-lg px-5 py-2.5 w-20 flex flex-row items-center justify-center transition-all duration-500 transform hover:scale-105">
                            <p>Add</p>
                        </div>
                    </button>

                </div>


                @else

                <div class="flex flex-row items-end space-x-4 mb-3 w-full dynamicField">

                    <div class="w-full">
                        <input type="text" name="optionName[]" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" maxlength="16" value="{{ $menuOption->name }}" required>
                    </div>

                    <div class="w-full">
                        <input type="number" min="1" step="any" name="optionPrice[]" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" value="{{ $menuOption->cost }}" required>

                        @error('optionPrice.*')
                        {{ $message }}
                        @enderror
                    </div>
                    <p class="font-bold">Cần đặt trước</p>

                    <select name="pre_order" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>
                        <option value="0" {{ old('pre_order') == '0' ? 'selected' : '' }}>Không</option>
                        <option value="1" {{ old('pre_order') == '1' ? 'selected' : '' }}>Có</option>
                    </select>

                    @error('pre_order')
                    <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                    <button type="button" class="remove-input-field">
                        <div class="bg-red-800 hover:bg-red-700 text-white text-center rounded-lg px-5 py-2.5 w-20 flex flex-row items-center justify-center transition-all duration-500 transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                    </button>

                </div>

                @endif

                @endforeach

            </div>

            <button type="submit" class="border-3 hover:border-green-700 border-green-800 hover:bg-green-700 bg-green-800 text-white py-4 rounded-lg font-bold transition-all duration-500 transform hover:scale-105">
                <p>Xác nhận Chỉnh sửa</p>
            </button>

            <a href="{{ route('menu.index') }}" class="border-3 hover:border-red-700 border-red-800 hover:bg-red-700 bg-red-800 text-white py-4 rounded-lg text-center font-bold transition-all duration-500 transform hover:scale-105">
                Huỷ
            </a>


        </div>

    </form>

</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function() {
        ++i;
        $("#dynamicAddRemove").append('<div class="flex flex-row items-end space-x-4 mb-3 w-full dynamicField"><div class="w-full"><input type="text" name="optionName[]" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required></div><div class="w-full"><input type="number" min="1" step="any" name="optionPrice[]" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required></div><button type="button" class="remove-input-field"><div class="bg-red-800 hover:bg-red-700 text-white text-center rounded-lg px-5 py-2.5 w-20 flex flex-row items-center justify-center transition-all duration-500 transform hover:scale-105"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></div></button></div>');
    });
    $(document).on('click', '.remove-input-field', function() {
        $(this).parents('.dynamicField').remove();
    });
</script>




@endsection