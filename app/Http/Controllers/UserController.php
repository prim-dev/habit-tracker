<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Display Users (Admin)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $users = User::latest()->get();
        return view('users', compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store User (Admin)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
{
    $validated = $request->validate([

        'name' => 'required|string|max:255',

        'email' => 'required|email|unique:users',

        'password' => 'required|min:6|confirmed',

    ]);

    User::create([

        'name' => $validated['name'],

        'email' => $validated['email'],

        'password' => bcrypt($validated['password']),

    ]);

    return redirect()->back()->with('success', 'User added successfully');
}

    /*
    |--------------------------------------------------------------------------
    | Update User (Admin)
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, int $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([

        'name' => 'required|string|max:255',

        'email' => 'required|email|unique:users,email,' . $user->id,

        'password' => 'nullable|min:6|confirmed',

    ]);

    if (!empty($validated['password'])) {

        $validated['password'] = bcrypt($validated['password']);

    } else {

        unset($validated['password']);

    }

    $user->update($validated);

    return redirect()->back()->with('success', 'User updated successfully');
}

    /*
    |--------------------------------------------------------------------------
    | Delete User (Admin)
    |--------------------------------------------------------------------------
    */
    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | Show Profile (Logged-in User)
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Profile (Logged-in User)
    |--------------------------------------------------------------------------
    */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'address'=> 'nullable|string|max:255',
            'gender' => 'nullable|string|max:50',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
}
