<!-- resources/views/subcategories/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Subcategories</h1>
        <!-- Filter Dropdown -->
        <div class="flex items-center space-x-2 ml-auto">
        <a href="{{ route('subcategories.create') }}" class="mr-3 block p-2 bg-green-500  text-white hover:bg-gray-800 rounded">Create Subcategory</a>
        </div>
        <!-- Search Box -->
        <form method="get" action="{{ route('subcategories.index') }}">
    <div class="flex items-center space-x-2">
        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search" class="p-2 border border-gray-300 rounded">
        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </div>
</form>


    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">ID</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Name</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Parent Category</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Status</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableTableBody">
                @foreach($subcategories as $subcategory)
                    <tr class="sortableRow" data-id="{{ $subcategory->id }}">
                        <td class="py-2 px-4 border-b text-left">{{ $subcategory->id }}</td>
                        <td class="py-2 px-4 border-b text-left">{{ Illuminate\Support\Str::limit($subcategory->name, 15, '...') }}</td>
                        <td class="py-2 px-4 border-b text-left">
                        @if ($subcategory->category)
                        {{ Illuminate\Support\Str::limit($subcategory->category->name, 15, '...') }}
                @else
                    Unknown Category (ID: {{ $subcategory->parentcategory_id }})
                @endif
            </td>
            <td class="py-2 px-4 border-b text-left">
            <label class="switch">
    <input type="checkbox" data-subcategory-id="{{ $subcategory->id }}" {{ $subcategory->status === 'active' ? 'checked' : '' }} class="toggle-button hidden invisible sr-only" onclick="toggleSubcategoryStatus({{ $subcategory->id }})">
    <span class="slider">{!! $subcategory->status === 'active' ? '<i class="fas fa-toggle-on fa-lg"></i>' : '<i class="fas fa-toggle-off fa-lg"></i>' !!}</span>
</label>

                       
                        </td>
                        <td class="py-2 px-4 border-b text-left">
                            <a href="{{ route('subcategories.edit', $subcategory) }}" class="text-green-500 hover:underline mr-2">
                            <i class="fas fa-edit"></i>  Edit
                            </a>
                            <a href="{{ route('subcategories.delete-confirmation', $subcategory)}}"  class="text-red-500 hover:underline" onclick="confirmDelete({{ $subcategory->id }})">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<script>
    function toggleSubcategoryStatus(subcategoryId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/subcategories/${subcategoryId}/toggle-status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            // Add additional headers or data if needed
        })
        .then(response => response.json())
        .then(data => {
            // Update the UI based on the new status
            const toggleButton = document.querySelector(`[data-subcategory-id="${subcategoryId}"]`);
            const slider = toggleButton.nextElementSibling;

            if (data.status === 'active') {
                toggleButton.checked = true;
                slider.innerHTML = '<i class="fas fa-toggle-on fa-lg"></i>';
            } else {
                toggleButton.checked = false;
                slider.innerHTML = '<i class="fas fa-toggle-off fa-lg"></i>';
            }
        })
        .catch(error => {
            console.error('Error toggling status:', error);
            // Handle errors if needed
        });
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
 <script>
    function confirmDelete(subcategoryId) {
            window.location.href = '/subcategories/' +'/delete'+ subcategoryId;      
    }
</script>
@endsection
