<?php

namespace App\Http\Controllers;

use App\Mail\GeneralNotificationMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view("send-emails.index", compact("users"));
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
        try {
            $validated = $request->validate([
                'subject' => 'required|string',
                'heading' => 'required|string',
                'body' => 'required|string',
                'users' => 'required|array',
            ]);

            $users = $request->users[0] === 'all'
                ? User::all()
                : User::whereIn('id', $request->users)->get();

            foreach ($users as $user) {
                Mail::to($user->email)->queue(
                    new GeneralNotificationMail($user, $validated['subject'], $validated['heading'], $validated['body'])
                );
            }

            return response()->json(['success' => 'Email queued successfully!'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to queue email. Please try again later.'], 500);
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
