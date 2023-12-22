<!-- resources/views/products/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
        
        <!-- Image -->
        <!-- <div class="mb-3">
        <img src="{{$product->image ? asset('storage/' . $product->image) : asset('/images/no-img.jpg')}}" alt="{{ $product->name }}" class="max-w-full h-auto w-48 h-48 object-cover">
        
        </div> -->
        <!-- Image -->
<div class="mb-3">
    <img src="{{$product->image ? asset('storage/' . $product->image) : asset('/images/no-img.jpg')}}" alt="{{ $product->name }}" class="max-w-full h-auto w-48 h-48 object-cover">

    <!-- Change Image Form -->
    <form method="POST" action="{{ route('products.change-image', $product->id) }}" enctype="multipart/form-data" class="mt-3">
        @csrf
        @method('PUT')

        <!-- Input for Image Change -->
        <input type="file" name="new_image" accept="image/*" class="mt-2">

        <!-- Submit Button -->
        <button type="submit" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded">Change Image</button>
    </form>
</div>

        
        <!-- Description -->
        <p class=" w-1/2 text-gray-700">{{ $product->description }}</p>

        <!-- Details -->
        <div class="mt-6 grid grid-cols-2 gap-4">
            <div>
                <strong>Category:</strong> {{ $product->category->name }}
            </div>
            <div>
                <strong>Subcategory:</strong> {{ $product->subcategory->name }}
            </div>
            <div>
                <strong>Brand:</strong> {{ $product->brand }}
            </div>
            <div>
                <strong>Model:</strong> {{ $product->model }}
            </div>
            <div>
                <strong>Price:</strong> ${{ $product->price }}
            </div>
            <div>
                <strong>Status:</strong> {{ $product->active ? 'Active' : 'Inactive' }}
            </div>
        </div>
        <div>
    <h2 class="text-lg font-semibold mt-4">Features:</h2>
    @if ($product->features)
    @foreach($product->features as $feature)
        <p>{{ $feature['key'] }}: {{ $feature['value'] }}</p>
    @endforeach
    @endif
</div>
        <!-- Downloadable Document -->
        <!-- @if ($product->document)
            <div class="mt-6">
                <strong>Document:</strong>
                <a href="{{ asset($product->document) }}" class="text-blue-500 hover:underline" download>
                    Download Document
                </a>
            </div>
        @endif -->
      <!-- Downloadable Document -->
<div class="mt-6">
    <strong>Document:</strong>
    @if ($product->document)
        <a href="{{ asset($product->document) }}" class="text-blue-500 hover:underline" download>
        <i class="fa-solid fa-file"></i> {{ $product->name }} Document
        </a>
    @else
        <span class="text-gray-500">No document uploaded</span>
    @endif
</div>

<!-- Change Document Form -->
<form method="post" action="{{ route('products.change-document', $product->id) }}" enctype="multipart/form-data" class="mt-4">
    @csrf
    @method('PUT')

    <label for="new_document" class="block mt-2">
        Choose a new document:
        <input type="file" name="new_document" id="new_document" accept=".pdf,.doc,.docx,.txt">
    </label>

    <button type="submit" class="bg-gray-500 text-white px-4 py-2 mt-2 rounded">Update Document</button>
</form>

    </div>
@endsection
