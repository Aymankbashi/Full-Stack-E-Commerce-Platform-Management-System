<?php

namespace App\Http\Controllers;

use App\Models\SupportSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * عرض صفحة هبوط الدعم الفني
     */
    public function landing()
    {
        return view('support.landing');
    }

    /**
     * عرض صفحة الدعم الفني
     */
    public function index()
    {
        $activeSessions = SupportSession::where('user_id', Auth::id())
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('support.index', compact('activeSessions'));
    }

    /**
     * إنشاء جلسة دعم جديدة
     */
    public function createSession(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'nullable|string|max:100',
            'message' => 'required|string',
        ]);

        // إنشاء جلسة جديدة
        $session = SupportSession::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'priority' => $request->priority,
            'category' => $request->category,
            'status' => 'active',
            'started_at' => now(),
        ]);

        // إضافة الرسالة الأولى
        ChatMessage::create([
            'session_id' => $session->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('support.chat', $session->id)
            ->with('success', 'تم إنشاء جلسة الدعم بنجاح');
    }

    /**
     * عرض صفحة الدردشة
     */
    public function chat($sessionId)
    {
        $session = SupportSession::with('messages.sender')
            ->where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // تحديث حالة قراءة الرسائل
        $session->messages()
            ->where('sender_id', '!=', Auth::id())
            ->update(['is_read' => true]);

        return view('support.chat', compact('session'));
    }

    /**
     * إرسال رسالة جديدة
     */
    public function sendMessage(Request $request, $sessionId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $session = SupportSession::where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        $message = ChatMessage::create([
            'session_id' => $session->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => false,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح');
    }

    /**
     * إنهاء الجلسة وحذف الدردشة
     */
    public function endSession($sessionId)
    {
        $session = SupportSession::where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        // إنهاء الجلسة وحذف الرسائل
        $session->closeSession();

        return redirect()->route('support.index')
            ->with('success', 'تم إنهاء الجلسة وحذف الدردشة بنجاح');
    }

    /**
     * API للحصول على الرسائل الجديدة
     */
    public function getNewMessages($sessionId)
    {
        $session = SupportSession::where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        $lastMessageId = request()->get('last_message_id', 0);

        $newMessages = $session->messages()
            ->where('id', '>', $lastMessageId)
            ->with('sender')
            ->get();

        return response()->json([
            'messages' => $newMessages,
            'session_active' => $session->isActive(),
        ]);
    }
}
