@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">Dashboard</h2>

        <!-- Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Products -->
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-600">Total Products</p>
                <h3 class="text-2xl font-bold">{{ $totalProducts }}</h3>
            </div>

            <!-- Total Categories -->
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-600">Total Categories</p>
                <h3 class="text-2xl font-bold">{{ $totalCategories }}</h3>
            </div>

            <!-- Total Subcategories -->
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-600">Total Subcategories</p>
                <h3 class="text-2xl font-bold">{{ $totalSubcategories }}</h3>
            </div>

            <!-- Total Queries -->
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-600">Total Queries</p>
                <h3 class="text-2xl font-bold">{{ $totalQueries }}</h3>
            </div>
        </div>

<!-- Additional Section -->
<div class="relative mt-8 h-64">
    <!-- Faded Background Image with Dark Overlay -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/bg3.jpg') }}');"></div>

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Text Overlay -->
    <div class="absolute inset-0 flex items-center justify-center z-10 text-white">
        <div class="text-center">
            <p class=" mb-4">Welcome to your dashboard! This is a minimalistic overview of your system.</p>
            
        </div>
    </div>
</div>

@endsection
