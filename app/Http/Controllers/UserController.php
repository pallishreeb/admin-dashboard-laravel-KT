<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\QueryException;
class UserController extends Controller
{
   // Show Register/Create Form
   public function create() {
    return view('users.register');
}

// Create New User
public function store(Request $request) {
    $formFields = $request->validate([
        'name' => ['required', 'min:3'],
        'email' => ['required', 'email', Rule::unique('users', 'email')],
        'mobile_number'=> ['required'],
        'password' => 'required|confirmed|min:6'
    ]);

    // Hash Password
    $formFields['password'] = bcrypt($formFields['password']);
    try {
    // Create User
    $user = User::create($formFields);
    }catch (QueryException $e) {
        if ($e->errorInfo[1] == 1062) { // Check if the error code corresponds to a duplicate entry
            return redirect()->route('pusers.register')->with('error', 'Email already exists.');
        } else {
            // Handle other query exceptions if needed
            return redirect()->route('users.register')->with('error', 'An error occurred while processing your request.');
        }
    }
    // Login
    auth()->login($user);

    return redirect('/')->with('message', 'User created and logged in');
}

// Logout User
public function logout(Request $request) {
    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('message', 'You have been logged out!');

}

// Show Login Form
public function login() {
    return view('users.login');
}

// Authenticate User
public function authenticate(Request $request) {
    $formFields = $request->validate([
        'email' => ['required', 'email'],
        'password' => 'required'
    ]);

    if(auth()->attempt($formFields)) {
        $request->session()->regenerate();

        return redirect('/')->with('message', 'You are now logged in!');
    }

    return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
}
public function userList()
{
    $users = User::all();
    return view('users.userList', compact('users'));
}

   //active inactive     
   public function toggleStatus(User $user)
   {
       $user->update([
           'active' => !$user->active,
       ]);
       return response()->json(['active' => !$user->active]);
   }

   public function edit(User $user)
{
    // Fetch the user roles from your role management system
    $roles = Role::all(); // Assuming Role is a model for managing roles

    return view('users.edit', compact('user', 'roles'));
}

public function update(Request $request, $id)
{

  // Update user record
    $user = User::find($id);
    $user->update([
        'role' => $request->input('role'),
        // Add other fields to update if needed
    ]);

    return redirect()->route('users.edit', $user->id)->with('success', 'User updated successfully!');
}
public function deleteConfirmation(User $user)
{
    return view('users.delete-confirmation', [
        'item' => $user,
        'type' => 'user',
        'route' => route('users.destroy', $user->id),
        'backRoute' => route('users.list'),
    ]);
}
public function destroy(User $user)
{
    $user->delete();

    return redirect()->route('users.list')->with('success', 'User deleted successfully.');
}
}
