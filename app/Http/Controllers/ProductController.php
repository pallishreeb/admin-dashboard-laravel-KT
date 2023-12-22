<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
{
    $query = Product::query();
    // Search by name, brand, or model
    if ($request->has('search')) {
        $searchTerm = $request->search;
        if (empty($searchTerm)) {
            $products = Product::with(['category', 'subcategory'])->orderBy('rank')->get();
        }else{
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', "%$searchTerm%")
              ->orWhere('brand', 'like', "%$searchTerm%")
              ->orWhere('model', 'like', "%$searchTerm%")
              ->orWhere('description', 'like', "%$searchTerm%");
        });
    }
    }

    $products = $query->with(['category', 'subcategory'])->orderBy('rank')->get();

    return view('products.index', compact('products'));
}
  
    // Show the form for creating a new product
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('products.create', compact('categories', 'subcategories'));
    }

    // Store a newly created product in storage
    public function store(Request $request){
         // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'required|exists:subcategories,id',
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'documents.*' => 'file|mimes:pdf,doc,docx|max:2048',
    ]);

// Generate alphanumeric productId
$lastProductId = Product::orderBy('created_at', 'desc')->value('productId');

// Extract the numeric part and increment
$numericPart = intval(substr($lastProductId, 2)) + 1;

// Keep generating until a unique productId is found
do {
    $nextProductId = 'KZ' . sprintf('%04d', $numericPart);
    $exists = Product::where('productId', $nextProductId)->exists();
    $numericPart++;
} while ($exists);
    
    // Create a new product
    $product = new Product([
        'productId' => $nextProductId,
        'name' => $request->input('name'),
        'category_id' => $request->input('category_id'),
        'subcategory_id' => $request->input('subcategory_id'),
        'brand' => $request->input('brand'),
        'model' => $request->input('model'),
        'price' => $request->input('price'), 
        'description' => $request->input('description'),
        'features' => $this->mapFeatures($request->input('features')),
        'active' => 1, // Default to active
        'isDeleted' => 0, // Default to not deleted
        'status' => 'approved', // Default status
        'rank' => 0,
    ]);

    if($request->hasFile('image')) {
        $product['image'] = $request->file('image')->store('images', 'public');
    }
    if($request->hasFile('document')) {
        $product['document'] = $request->file('document')->store('documents', 'public');
    }
    // Save the product
    $product->save();
  
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }
    public function show($id)
    {
        $product = Product::with(['category', 'subcategory'])->findOrFail($id);

        return view('products.show', compact('product'));
    }

    //active inactive     
    public function toggleStatus(Product $product)
    {
        $product->update([
            'active' => !$product->active,
        ]);
        return response()->json(['active' => !$product->active]);
    }
    //update position or rank
    public function updateRank(Request $request)
{
    $sortedIds = $request->input('sortedIds');
    foreach ($sortedIds as $key => $productId) {
        Product::where('id', $productId)->update(['rank' => $key + 1]);
    }

    return response()->json(['success' => true]);
}

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('products.edit', compact('product', 'categories', 'subcategories'));
    }

// Update the specified product in storage
public function update(Request $request, Product $product)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'required|exists:subcategories,id',
        'price' => 'required|numeric|min:0',
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    // Update the basic product information
    $product->update($validatedData);

     // Map features from request data
     $newFeatures = $this->mapFeatures($request->input('features'));

     // Update the features column
     $product->update(['features' => $newFeatures]);

    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}

    // Remove the specified product from storage
    public function deleteConfirmation(Product $product)
    {
        return view('products.delete-confirmation', [
            'item' => $product,
            'type' => 'product',
            'route' => route('products.destroy', $product->id),
            'backRoute' => route('products.index'),
        ]);
    }
    public function destroy($id) {
        // Logic to delete the product with the given ID
        Product::destroy($id);
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
    


    // Helper method to map features to array of objects
private function mapFeatures($features)
{
    $result = [];
    foreach ($features['key'] as $index => $key) {
        $result[] = [
            'key' => $key,
            'value' => $features['value'][$index],
        ];
    }
    return $result;
}
// In your controller
public function dashboard()
{
    $totalProducts = Product::count();
    $totalCategories = Category::count();
    $totalSubcategories = Subcategory::count();
    // $totalQueries = Query::count();
    $totalQueries=10;
    return view('dashboard', compact('totalProducts', 'totalCategories', 'totalSubcategories', 'totalQueries'));
}
public function changeImage(Request $request, Product $product)
{
    $request->validate([
        'new_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($request->hasFile('new_image')) {
        // Delete the existing image if it exists
        if ($product->image) {
            Storage::delete($product->image);
        }
    
        $newImage = $product['image'] = $request->file('new_image')->store('images', 'public');


        // Update the product with the new image path
        $product->update([
            'image' => $newImage,
        ]);
    }

    return redirect()->route('products.show', $product->id)->with('success', 'Image updated successfully!');
}

public function changeDocument(Request $request, Product $product)
{
    $request->validate([
        'new_document' => 'file|mimes:pdf,doc,docx,txt|max:2048',
    ]);

    if ($request->hasFile('new_document')) {
        // Delete the existing document if it exists
        if ($product->document) {
            Storage::delete($product->document);
        }

        // Upload the new document
        $newDocument = $request->file('new_document')->store('documents', 'public');

        // Update the product with the new document path
        $product->document = $newDocument;
        $product->save();
    }

    return redirect()->route('products.show', $product->id)->with('success', 'Document updated successfully!');
}

}
