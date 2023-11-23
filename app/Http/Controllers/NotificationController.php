<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        // Logic for creating a new notification form
        return view('notifications.create');
    }

    public function store(Request $request)
    {
        // Logic for storing a new notification
        Notification::create($request->all());

        return redirect()->route('notifications.index')
            ->with('success', 'Notification created successfully');
    }

    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return view('notifications.show', compact('notification'));
    }

    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        return view('notifications.edit', compact('notification'));
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update($request->all());

        return redirect()->route('notifications.index')
            ->with('success', 'Notification updated successfully');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully');
    }
}
