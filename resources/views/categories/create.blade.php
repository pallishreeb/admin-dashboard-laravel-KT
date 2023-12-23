<!-- resources/views/categories/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-5">
      
        <div class="w-full max-w-md bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-6">Create Category</h1>

            <form method="post" action="{{ route('categories.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name:</label>
                    <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-md">
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Category Type:</label>
                    <select id="type" name="type" class="mt-1 p-2 w-full border rounded-md">
                        <option value="service">Service</option>
                        <option value="product">Product</option>
                    </select>
                </div>

                <!-- Add other fields as needed -->

                <div>
                    <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-gray-600">Create Category</button>
                    <a href="{{ route('categories.index') }}" class="block mt-1 w-full bg-gray-500  text-center text-white p-2 rounded-md hover:bg-gray-600">Cancel</a>

                </div>
            </form>
        </div>
    </div>
@endsection
