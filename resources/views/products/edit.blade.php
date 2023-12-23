@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-5">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="w-full max-w bg-white p-8 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-2">Edit Product</h1>

            <form method="post" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT') <!-- Add this line to specify the HTTP method -->

                <div class="flex">
                    <div class="w-1/2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name:</label>
                        <input type="text" id="name" name="name" value="{{ $product->name }}" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="w-1/2">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
                        <input type="number" id="price" name="price" value="{{ $product->price }}" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                </div>

                <div class="flex">
                    <div class="w-1/2">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category:</label>
                        <select id="category_id" name="category_id" class="mt-1 p-2 w-full border rounded-md">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-1/2">
                        <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Subcategory:</label>
                        <select id="subcategory_id" name="subcategory_id" class="mt-1 p-2 w-full border rounded-md">
                            @foreach($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex">
                    <div class="w-1/2">
                        <label for="brand" class="block text-sm font-medium text-gray-700">Brand:</label>
                        <input type="text" id="brand" name="brand" value="{{ $product->brand }}" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="w-1/2">
                        <label for="model" class="block text-sm font-medium text-gray-700">Model:</label>
                        <input type="text" id="model" name="model" value="{{ $product->model }}" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                    <textarea id="description" name="description" class="mt-1 p-2 w-full border rounded-md">{{ $product->description }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Features:</label>
                    <divendif id="features-container" class="space-y-2">
                        @if($product->features)
                        @foreach($product->features as $feature)
                            <div class="flex items-center space-x-2">
                                <input type="text" name="features[key][]" value="{{ $feature['key'] }}" placeholder="Key" class="w-1/2 p-2 border rounded-md">
                                <input type="text" name="features[value][]" value="{{ $feature['value'] }}" placeholder="Value" class="w-1/2 p-2 border rounded-md">
                                <button type="button" onclick="removeFeatureField(this)" class="px-3 py-2 bg-red-500 text-white rounded-md">-</button>
                            </div>
                        @endforeach
                        @endif
                        <div class="flex items-center space-x-2">
                            <input type="text" name="features[key][]" placeholder="Key" class="w-1/2 p-2 border rounded-md">
                            <input type="text" name="features[value][]" placeholder="Value" class="w-1/2 p-2 border rounded-md">
                            <button type="button" onclick="addFeatureField()" class="px-3 py-2 bg-blue-500 text-white rounded-md">+</button>
                        </div>
                    </divendif
                </div>

                <div class="flex items-center space-x-4">
                <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-gray-600">Update Product</button>
                
                <a href="{{ route('products.index') }}" class="w-full bg-gray-500 text-center text-white p-2 rounded-md hover:bg-gray-600">Cancel</a>
            </div>
            </form>
        </div>
    </div>
    <script>
        function addFeatureField() {
            const container = document.getElementById('features-container');

            // Create a new input field for features
            const newField = document.createElement('div');
            newField.classList.add('flex', 'items-center', 'space-x-2');

            const keyInput = document.createElement('input');
            keyInput.type = 'text';
            keyInput.name = 'features[key][]';
            keyInput.placeholder = 'Key';
            keyInput.classList.add('p-2', 'border', 'rounded-md');

            const valueInput = document.createElement('input');
            valueInput.type = 'text';
            valueInput.name = 'features[value][]';
            valueInput.placeholder = 'Value';
            valueInput.classList.add('p-2', 'border', 'rounded-md');

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.textContent = '-';
            removeButton.classList.add('px-3', 'py-2', 'bg-red-500', 'text-white', 'rounded-md');
            removeButton.addEventListener('click', () => container.removeChild(newField));

            newField.appendChild(keyInput);
            newField.appendChild(valueInput);
            newField.appendChild(removeButton);

            container.appendChild(newField);
        }
        function removeFeatureField(button) {
        // Find the parent container of the clicked button and remove it
        const container = button.parentNode;
        container.parentNode.removeChild(container);
    }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Listen for the category dropdown change
        document.getElementById('category_id').addEventListener('change', function () {
            // Get the selected category value
            var categoryId = this.value;

            // Make an Axios request to fetch subcategories based on the selected category
            axios.get('/get-subcategories/' + categoryId)
                .then(function (response) {
                    console.log(response)
                    // Clear existing options in the subcategory dropdown
                    document.getElementById('subcategory_id').innerHTML = '';

                    // Append new options based on the fetched data
                    response.data.forEach(function (subcategory) {
                        var option = document.createElement('option');
                        option.value = subcategory.id;
                        option.text = subcategory.name;
                        document.getElementById('subcategory_id').appendChild(option);
                    });
                })
                .catch(function (error) {
                    console.error('Error fetching subcategories:', error);
                });
        });
    });
</script>
@endsection
