<?php

namespace App\Http\Controllers;

use App\Models\BotConfiguration;
use Illuminate\Http\Request;

class ConnectedBotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Fetch all connected bots
        $bots = BotConfiguration::all();
        return view('connected-bots.index', compact('bots'));
    }

    public function update(Request $request, BotConfiguration $bot)
    {
        $request->validate([
            'status_message' => 'nullable|string|max:255',
            'image_url' => 'nullable|url',
        ]);

        $bot->update([
            'connection_status' => $request->status_message,
            'image_url' => $request->image_url,
        ]);

        return redirect()->route('connected-bots.index')->with('success', 'Bot updated successfully.');
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
