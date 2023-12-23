<!-- resources/views/products.blade.php -->

@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Product List</h1>

        <!-- Filter Dropdown -->
        <div class="flex items-center space-x-2 ml-auto">
        <a href="{{ route('products.create') }}" class="mr-3 block p-2 bg-green-500  text-white hover:bg-gray-800 rounded">Create Product</a>

        </div>

        <!-- Search Box -->
        <div class="flex items-center space-x-2">
       <form id="searchForm" action="{{ route('products.index') }}"  method="GET">
        <!-- <label for="search" class="text-sm">Search:</label> -->
        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search" class="p-2 border border-gray-300 rounded">
        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
</div>

    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">ID</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Name</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Category</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Subcategory</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Brand</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Model</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Status</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableTableBody">
                @foreach($products as $product)
                    <tr class="sortableRow" data-id="{{ $product->id }}">
                        <td class="py-2 px-4 border-b text-left">{{ $product->productId }}</td>
                        <td class="py-2 px-4 border-b text-left">{{ Illuminate\Support\Str::limit($product->name, 15, '...') }}</td>
                        <td class="py-2 px-4 border-b text-left">{{ Illuminate\Support\Str::limit($product->category->name, 15, '...') }}</td>
                        <td class="py-2 px-4 border-b text-left">{{ Illuminate\Support\Str::limit($product->subcategory->name, 15, '...') }}</td>
                        <td class="py-2 px-4 border-b text-left">{{ Illuminate\Support\Str::limit($product->brand, 15, '...') }}</td>
                        <td class="py-2 px-4 border-b text-left">{{ Illuminate\Support\Str::limit($product->model, 15, '...') }}</td>
                        <td class="py-2 px-4 border-b text-left">
                        <label class="switch">
                        <input type="checkbox" data-product-id="{{ $product->id }}" {{ $product->active ? 'checked' : '' }} class="toggle-button hidden invisible sr-only">
                        <span class="slider">
                            {!! $product->active
                                ? '<i class="fas fa-toggle-on fa-lg"></i> Active'
                                : '<i class="fas fa-toggle-off fa-lg"></i> Inactive' !!}
                        </span>
                        </label>
                        </td>
                        <td class="py-2 px-4 border-b text-left">
                            
                        <a href="{{ route('products.show', $product->id) }}" class="text-blue-500 hover:underline mr-2">
                         <i class="fas fa-eye"></i> View
                        </a>

                         <a href="{{ route('products.edit', $product->id) }}" class="text-green-500 hover:underline mr-2">
                             <i class="fas fa-edit"></i> Edit
                        </a>

                            <a href="{{ route('products.delete-confirmation', $product) }}" class="text-red-500 hover:underline" onclick="confirmDelete({{ $product->id }})">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toggleButtons = document.querySelectorAll('.toggle-button');

        toggleButtons.forEach(function (button) {
            button.addEventListener('change', function () {
                var productId = this.dataset.productId;
                var isActive = this.checked;

                // Make an Axios request to update the product status
                axios.post('/products/' + productId + '/toggle-status', {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    active: isActive
                })
                .then(function (response) {
                    // Update the status text with dynamic icon
                    var statusElement = document.querySelector('.toggle-button[data-product-id="' + productId + '"] + .slider');
                    statusElement.innerHTML = isActive
                        ? '<i class="fas fa-toggle-on fa-lg"></i> Active'
                        : '<i class="fas fa-toggle-off fa-lg"></i> Inactive';
                })
                .catch(function (error) {
                    alert('Error updating product status');
                });
            });
        });
    });
</script>
<script>
    function confirmDelete(productId) {
            // If user clicks OK, redirect to delete route
            window.location.href = '/products/' + '/delete' + productId ;      
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Sortable(document.getElementById('sortableTableBody'), {
            animation: 150,
            onUpdate: function (evt) {
                // Handle the update event, e.g., send an AJAX request to update the order in the database
                updateRank();
            },
        });
    });

    function updateRank() {
        // Get the sorted item IDs
        var sortedIds = Array.from(document.querySelectorAll('.sortableRow')).map(function (el) {
            return el.getAttribute('data-id');
        });
        fetch('/update-rank', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ sortedIds: sortedIds }),
        })
            .then(response => response.json())
            .then(data => {
                // Handle the response if needed
            })
            .catch(error => console.error('Error updating rank:', error));
    }
</script>

<!-- Link to all custom JavaScript file -->
<!-- <script src="{{ asset('js/product.js') }}"></script> -->

@endsection
