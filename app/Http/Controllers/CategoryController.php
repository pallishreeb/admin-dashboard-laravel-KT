<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::orderBy('rank');
    
        // Check if there is a search query
        if ($request->has('search')) {
            $search = $request->input('search');
            // Add a where clause to filter by category name
            $query->where('name', 'like', '%' . $search . '%');
        }
        $categories = $query->get();
    
        return view('categories.index', compact('categories'));
    }


    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // Validation logic here if needed

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }
        //active inactive     
        public function toggleStatus(Request $request, Category $category)
        {
            // Toggle the status
            $newStatus = $category->status === 'active' ? 'inactive' : 'active';
            $category->update(['status' => $newStatus]);
        
            // You can return a response if needed
            return response()->json(['status' => $newStatus]);
        }
        //update position or rank
        public function updateRank(Request $request)
    {
        $sortedIds = $request->input('sortedIds');
        foreach ($sortedIds as $key => $categoryId) {
            Category::where('id', $categoryId)->update(['rank' => $key + 1]);
        }
    
        return response()->json(['success' => true]);
    }
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Validation logic here if needed

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
    public function deleteConfirmation(Category $category)
    {
        return view('categories.delete-confirmation', [
            'item' => $category,
            'type' => 'category',
            'route' => route('categories.destroy', $category->id),
            'backRoute' => route('categories.index'),
        ]);
    }
    

    public function destroy(Category $category)
    {
        try {
            // Check if the category is linked with other tables
            if ($category->subcategories()->exists() || $category->products()->exists()) {
                throw new \Exception('Category is linked with other tables and cannot be deleted.');
            }
    
            $category->delete();
    
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', $e->getMessage());
        }
    }
    
}
