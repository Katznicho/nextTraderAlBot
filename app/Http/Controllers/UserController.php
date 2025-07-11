<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        #fecth all users
        $users = User::all();
        return view('users.index', compact('users'));

    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'balance' => 'required|numeric',
        'profit' => 'required|numeric',
        'total_trades' => 'required|integer',
    ]);

    $user->update([
        'balance' => $request->balance,
        'profit' => $request->profit,
        'total_trades' => $request->total_trades,
    ]);

    return redirect()->route('users.index')->with('success', 'User updated successfully!');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return view('users.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return view('users.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
