<!-- resources/views/admin/queries/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="bg-white p-4 shadow-md rounded-md">
    <h2 class="text-xl font-semibold mb-4">Query Details</h2>

    @foreach ($queries as $query)
    <div class="border-b mb-4 pb-4">
        <!-- Card for each query -->
        <div class="flex justify-between items-start">
            <!-- Left Partition: Column Name -->
            <div class="w-1/3 pr-4">
                <div class="font-semibold">{{ __('Product') }}</div>
                <div class="font-semibold">{{ __('User Name') }}</div>
                <div class="font-semibold">{{ __('Mobile') }}</div>
                <div class="font-semibold">{{ __('Email') }}</div>
                <div class="font-semibold">{{ __('Query Message') }}</div>
            </div>

            <!-- Right Partition: Value -->
            <div class="w-2/3">
                <div>{{ $query->product->name}}</div>
                <div>{{ $query->user_name }}</div>
                <div>{{ $query->mobile }}</div>
                <div>{{ $query->email }}</div>
                <div>{{ $query->query_message }}</div>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection
