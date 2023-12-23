<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\DeleteConfirmationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomForgotPasswordController;
use App\Http\Controllers\QueryController;

/*


|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/  

//Dashboard
Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Index
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('auth');

// Create
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('auth');
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('auth');
Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->middleware('auth');
Route::post('/update-rank', [ProductController::class, 'updateRank'])->middleware('auth');


// Show
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('auth');

// Update
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('auth');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('auth');
Route::put('/products/{product}/change-image', [ProductController::class, 'changeImage'])->name('products.change-image')->middleware('auth');
Route::put('/products/{product}/change-document', [ProductController::class, 'changeDocument'])->name('products.change-document')->middleware('auth');

// Destroy
Route::get('/products/delete/{product}', [ProductController::class, 'deleteConfirmation'])->name('products.delete-confirmation')->middleware('auth');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('auth');



// Subcategory routes
// Index
Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('subcategories.index')->middleware('auth');
Route::get('/get-subcategories/{category}', [SubcategoryController::class, 'getSubcategories']);
// Create
Route::get('/subcategories/create', [SubcategoryController::class, 'create'])->name('subcategories.create')->middleware('auth');
Route::post('/subcategories', [SubcategoryController::class, 'store'])->name('subcategories.store');
Route::put('/subcategories/{subcategory}/toggle-status', [SubcategoryController::class, 'toggleStatus'])
    ->name('subcategories.toggle-status');
Route::post('/update-rank', [SubcategoryController::class, 'updateRank']);
// Update
Route::get('/subcategories/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('subcategories.edit')->middleware('auth');
Route::put('/subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('subcategories.update');

// Destroy
Route::get('/subcategories/delete/{subcategory}', [SubcategoryController::class, 'deleteConfirmation'])->name('subcategories.delete-confirmation')->middleware('auth');
Route::delete('/subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');

// Category routes
// Index
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index')->middleware('auth');


// Create
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('auth');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::put('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
    ->name('categories.toggle-status');
Route::post('/update-rank', [CategoryController::class, 'updateRank']);
// Update
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

// Destroy
Route::get('/categories/delete/{category}', [CategoryController::class, 'deleteConfirmation'])->name('categories.delete-confirmation');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

//Users Routes
// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create New User
Route::post('/register', [UserController::class, 'store'])->name('store');

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->name('authenticate');

Route::get('/users/list', [UserController::class, 'userList'])->name('users.list')->middleware('auth');

Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus']);

Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

// Destroy
Route::get('/users/delete/{user}', [UserController::class, 'deleteConfirmation'])->name('users.delete-confirmation')->middleware('auth');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// password reset

// Show forgot password form
Route::get('/forgot-password', [CustomForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');

// Handle forgot password form submission
Route::post('/forgot-password', [CustomForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Show reset password form
Route::get('/reset-password/{token}', [CustomForgotPasswordController::class, 'showResetForm'])->name('password.reset');

// Handle reset password form submission
Route::post('/reset-password', [CustomForgotPasswordController::class, 'reset'])->name('password.update');



Route::middleware(['auth'])->group(function () {
    // Add other admin routes as needed
    Route::get('/queries', [QueryController::class, 'index'])->name('queries.index');
});