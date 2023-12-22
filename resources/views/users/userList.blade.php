<!-- resources/views/users/userList.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">User List</h2>

        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Active</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            @if ($user->mobile_number !== null)
                                {{ $user->mobile_number }}
                            @else
                                NA
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                        @if ($user->active !== null)
                            <label class="switch">
                                <input type="checkbox" data-user-id="{{ $user->id }}" {{ $user->active ? 'checked' : '' }} class="toggle-button hidden invisible sr-only">
                                <span class="slider">
                                    {!! $user->active
                                        ? '<i class="fas fa-toggle-on fa-lg"></i> Active'
                                        : '<i class="fas fa-toggle-off fa-lg"></i> Inactive' !!}
                                </span>
                            </label>
                        @else
                        NA
                        @endif
                    </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                        <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:underline">
                        <i class="fas fa-edit"></i>Edit</a>

                        <a href="{{ route('users.delete-confirmation', $user)}}"  class="text-red-500 hover:underline" onclick="confirmDelete({{ $user->id }})">
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
                var userId = this.dataset.userId;
                var isActive = this.checked;

                // Make an Axios request to update the product status
                axios.post('/users/' + userId + '/toggle-status', {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    active: isActive
                })
                .then(function (response) {
                    // Update the status text with dynamic icon
                    var statusElement = document.querySelector('.toggle-button[data-user-id="' + userId + '"] + .slider');
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
    function confirmDelete(userId) {
            window.location.href = '/users/' +'/delete'+ userId;      
    }
</script>
@endsection
