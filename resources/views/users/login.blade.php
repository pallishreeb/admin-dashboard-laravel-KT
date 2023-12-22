<!-- resources/views/auth/login.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="flex mt-5 justify-center h-screen">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h1 class="text-2xl font-bold mb-6">Login</h1>

                <form method="POST" action="{{route('authenticate')}}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700"><i class="fa-solid fa-user mr-2"></i>Email:</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="mt-1 p-2 w-full border rounded-md @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700"><i class="fa-solid fa-key mr-2"></i>Password:</label>
                        <input type="password" id="password" name="password" class="mt-1 p-2 w-full border rounded-md @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember" class="form-checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm">Remember me</span>
                        </label>

                        <a href="#" class="text-blue-500 hover:underline">Forgot Password?</a>
                    </div>

                    <div>
                        <button type="submit" class="w-full bg-gray-700 text-white p-2 rounded-md hover:bg-gray-800"><i class="fas fa-sign-in mr-2"></i>Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
