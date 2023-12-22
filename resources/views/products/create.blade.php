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
            <h1 class="text-2xl font-bold mb-2">Create Product</h1>

            <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="flex">
                <div class="w-1/2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name:</label>
                    <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-md">
                </div>
                <div class="w-1/2">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
                    <input type="number" id="price" name="price" class="mt-1 p-2 w-full border rounded-md">
                </div>
               </div>
               <div class="flex">


                <div class="w-1/2">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category:</label>
                    <select id="category_id" name="category_id" class="mt-1 p-2 w-full border rounded-md">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-1/2">
                    <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Subcategory:</label>
                    <select id="subcategory_id" name="subcategory_id" class="mt-1 p-2 w-full border rounded-md">
                        @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                </div>
                <div class="flex">
                <div  class="w-1/2">
                    <label for="brand" class="block text-sm font-medium text-gray-700">Brand:</label>
                    <input type="text" id="brand" name="brand" class="mt-1 p-2 w-full border rounded-md">
                </div>

                <div  class="w-1/2">
                    <label for="model" class="block text-sm font-medium text-gray-700">Model:</label>
                    <input type="text" id="model" name="model" class="mt-1 p-2 w-full border rounded-md">
                </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                    <textarea id="description" name="description" class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>

                 <!-- Dynamic Key-Value Pair Input Section -->
                 <div>
                    <label class="block text-sm font-medium text-gray-700">Features:</label>

                    <div id="features-container" class="space-y-2">
                        <!-- Default input field for features -->
                        <div class="flex items-center space-x-2">
                            <input type="text" name="features[key][]" placeholder="Key" class="w-1/2 p-2 border rounded-md">
                            <input type="text" name="features[value][]" placeholder="Value" class="w-1/2 p-2 border rounded-md">
                            <button type="button" onclick="addFeatureField()" class="px-3 py-2 bg-blue-500 text-white rounded-md">+</button>
                        </div>
                    </div>
                </div>
                <div class="flex">
                <div class="w-1/2">
                    <label for="image" class="block text-sm font-medium text-gray-700">Images:</label>
                    <input type="file" id="image" name="image" class="mt-1 p-2 w-full border rounded-md">
                </div>

                <div class="w-1/2">
                    <label for="document" class="block text-sm font-medium text-gray-700">Documents:</label>
                    <input type="file" id="document" name="document"  class="mt-1 p-2 w-full border rounded-md">
                </div>
              
                </div>
                <div>
                    <button type="submit" class="w-full bg-gray-500 text-white p-2 rounded-md hover:bg-gray-600">Create Product</button>
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
            keyInput.classList.add('w-1/2','p-2', 'border', 'rounded-md');

            const valueInput = document.createElement('input');
            valueInput.type = 'text';
            valueInput.name = 'features[value][]';
            valueInput.placeholder = 'Value';
            valueInput.classList.add('w-1/2','p-2', 'border', 'rounded-md');

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
    </script>
@endsection
