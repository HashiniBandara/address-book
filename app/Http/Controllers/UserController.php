<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserController extends Controller
{

    public function UserDashboard()
    {
        // return view('user.user_dashboard');
        return view('user.index');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // $users = Product::latest()->paginate(5);

        $users = User::where('deleted_at', '=', 0)->oldest()->paginate(50);

        return view('superadmin.user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 50);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('superadmin.user.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,superadmin,user',
        ]);
        User::create($request->all());
        return redirect()->route('superadmin.user.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('superadmin.user.show', compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('superadmin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users',
            // 'password' => 'required|string|min:8',
            // 'role' => 'required|in:admin,superadmin,user',
        ]);
        $user->update($request->all());
        return redirect()->route('superadmin.user.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    /* public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('superadmin.user.index')
            ->with('success', 'User deleted successfully');
    } */

    public function destroy(User $user): RedirectResponse
    {
        $user->update(['deleted_at' => 1]); //set deleted_at=1

        return redirect()->route('superadmin.user.index')
            ->with('success', 'Product deleted successfully');
    }
}
