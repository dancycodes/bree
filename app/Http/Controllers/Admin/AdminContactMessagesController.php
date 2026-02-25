<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminContactMessagesController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('messages.view');

        $messages = ContactMessage::query()
            ->orderByRaw("CASE WHEN status = 'new' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        $unreadCount = ContactMessage::where('status', 'new')->count();

        return gale()->view('admin.messages.index', compact('messages', 'unreadCount'), web: true);
    }

    public function show(Request $request, ContactMessage $message): mixed
    {
        $this->authorize('messages.view');

        if ($message->status === 'new') {
            $message->update(['status' => 'read']);
        }

        if ($request->isGale()) {
            $unreadCount = ContactMessage::where('status', 'new')->count();

            return gale()
                ->fragment('admin.messages.index', 'message-detail', compact('message'))
                ->fragment('admin.messages.index', 'messages-list', [
                    'messages' => ContactMessage::query()
                        ->orderByRaw("CASE WHEN status = 'new' THEN 0 ELSE 1 END")
                        ->orderBy('created_at', 'desc')
                        ->paginate(30),
                    'unreadCount' => $unreadCount,
                ]);
        }

        return gale()->view('admin.messages.index', [
            'messages' => ContactMessage::query()
                ->orderByRaw("CASE WHEN status = 'new' THEN 0 ELSE 1 END")
                ->orderBy('created_at', 'desc')
                ->paginate(30),
            'unreadCount' => ContactMessage::where('status', 'new')->count(),
        ], web: true);
    }

    public function destroy(Request $request, ContactMessage $message): mixed
    {
        $this->authorize('messages.delete');

        $message->delete();

        $messages = ContactMessage::query()
            ->orderByRaw("CASE WHEN status = 'new' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        $unreadCount = ContactMessage::where('status', 'new')->count();

        return gale()
            ->fragment('admin.messages.index', 'message-detail', [])
            ->fragment('admin.messages.index', 'messages-list', compact('messages', 'unreadCount'))
            ->dispatch('toast', ['message' => 'Message supprimé', 'type' => 'success']);
    }
}
