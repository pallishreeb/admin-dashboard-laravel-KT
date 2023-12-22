<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Subcategory::query();
    
        // Order by rank
        $query->orderBy('rank');
    
        // Search by name
        $search = $request->input('search');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
    
        // Get the subcategories
        $subcategories = $query->get();
    
        return view('subcategories.index', compact('subcategories'));
    }
    

    public function create()
    {
        $categories = Category::all();

        return view('subcategories.create', compact('categories'));
    }


    public function store(Request $request)
    {
        // Validation logic here if needed

        Subcategory::create($request->all());

        return redirect()->route('subcategories.index')->with('success', 'Subcategory created successfully.');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all(); // Replace this with your logic to get the categories
    
        return view('subcategories.edit', compact('subcategory', 'categories'));
    }
    
    public function update(Request $request, Subcategory $subcategory)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'parent_category' => 'required|exists:categories,id',
        // Add other validation rules as needed
    ]);

    $subcategory->update([
        'name' => $validatedData['name'],
        'parentcategory_id' => $validatedData['parent_category'],
        // Update other fields as needed
    ]);

    return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully!');
}
    public function deleteConfirmation(Subcategory $subcategory)
    {
        return view('subcategories.delete-confirmation', [
            'item' => $subcategory,
            'type' => 'subcategory',
            'route' => route('subcategories.destroy', $subcategory->id),
            'backRoute' => route('subcategories.index'),
        ]);
    }
    
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }
    //active inactive     
    public function toggleStatus(Request $request, Subcategory $subcategory)
    {
        // Validate the request if needed
    
        // Toggle the status
        $newStatus = $subcategory->status === 'active' ? 'inactive' : 'active';
        $subcategory->update(['status' => $newStatus]);
    
        // You can return a response if needed
        return response()->json(['status' => $newStatus]);
    }
    //update position or rank
    public function updateRank(Request $request)
    {
        $sortedIds = $request->input('sortedIds');
        foreach ($sortedIds as $key => $subcategoryId) {
            Subcategory::where('id', $subcategoryId)->update(['rank' => $key + 1]);
        }
       
        return response()->json(['success' => true]);
       }
}
