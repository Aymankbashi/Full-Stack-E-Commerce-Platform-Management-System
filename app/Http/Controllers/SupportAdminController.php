<?php

namespace App\Http\Controllers;

use App\Models\SupportSession;
use App\Models\ChatMessage;
use App\Models\ReplyTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportAdminController extends Controller
{
    /**
     * عرض لوحة تحكم الدعم الفني
     */
    public function dashboard()
    {
        // إحصائيات عامة
        $stats = [
            'total_sessions' => SupportSession::count(),
            'active_sessions' => SupportSession::where('status', 'active')->count(),
            'closed_sessions' => SupportSession::where('status', 'closed')->count(),
            'pending_sessions' => SupportSession::where('status', 'active')
                ->whereNull('support_agent_id')
                ->count(),
            'high_priority' => SupportSession::where('status', 'active')
                ->where('priority', 'high')
                ->count(),
            'urgent_priority' => SupportSession::where('status', 'active')
                ->where('priority', 'urgent')
                ->count(),
        ];

        // الجلسات النشطة حسب الأولوية
        $activeSessions = SupportSession::with('user', 'messages')
            ->where('status', 'active')
            ->orderByRaw("CASE 
                WHEN priority = 'urgent' THEN 1
                WHEN priority = 'high' THEN 2
                WHEN priority = 'medium' THEN 3
                WHEN priority = 'low' THEN 4
                ELSE 5
            END")
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // الجلسات المخصصة للموظف الحالي
        $mySessions = SupportSession::with('user', 'messages')
            ->where('support_agent_id', Auth::id())
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('support.admin.dashboard', compact('stats', 'activeSessions', 'mySessions'));
    }

    /**
     * عرض تفاصيل جلسة معينة
     */
    public function showSession($sessionId)
    {
        $session = SupportSession::with('user', 'messages.sender')
            ->where('id', $sessionId)
            ->firstOrFail();

        // تحديث حالة قراءة الرسائل
        $session->messages()
            ->where('sender_id', '!=', Auth::id())
            ->update(['is_read' => true]);

        return view('support.admin.session', compact('session'));
    }

    /**
     * عرض الدردشة الاحترافية
     */
    public function professionalChat($sessionId)
    {
        $session = SupportSession::with(['user', 'messages.sender', 'supportAgent'])
            ->where('id', $sessionId)
            ->firstOrFail();

        // تحديث حالة قراءة الرسائل
        $session->messages()
            ->where('sender_id', '!=', Auth::id())
            ->update(['is_read' => true]);

        // جلب قوالب الردود
        $replyTemplates = ReplyTemplate::orderBy('category')
            ->get();

        return view('support.admin.professional-chat-clean', compact('session', 'replyTemplates'));
    }

    /**
     * تعيين جلسة لموظف دعم
     */
    public function assignSession(Request $request, $sessionId)
    {
        $session = SupportSession::findOrFail($sessionId);

        $session->update([
            'support_agent_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'تم تعيين الجلسة لك بنجاح');
    }

    /**
     * إرسال رسالة من موظف الدعم
     */
    public function sendMessage(Request $request, $sessionId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $session = SupportSession::findOrFail($sessionId);

        // تعيين الجلسة للموظف إذا لم تكن معينة
        if (!$session->support_agent_id) {
            $session->update(['support_agent_id' => Auth::id()]);
        }

        ChatMessage::create([
            'session_id' => $session->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => false,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => ChatMessage::with('sender')->latest()->first(),
            ]);
        }

        return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح');
    }

    /**
     * إغلاق جلسة
     */
    public function closeSession($sessionId)
    {
        $session = SupportSession::findOrFail($sessionId);

        $session->update([
            'status' => 'closed',
            'ended_at' => now(),
        ]);

        // حذف الرسائل
        $session->messages()->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إغلاق الجلسة وحذف الرسائل بنجاح'
            ]);
        }

        return redirect()->route('support.admin.dashboard')
            ->with('success', 'تم إغلاق الجلسة وحذف الرسائل بنجاح');
    }

    /**
     * الحصول على الرسائل الجديدة
     */
    public function getNewMessages($sessionId)
    {
        $session = SupportSession::findOrFail($sessionId);

        $lastMessageId = request()->get('last_message_id', 0);

        $newMessages = $session->messages()
            ->where('id', '>', $lastMessageId)
            ->with('sender')
            ->get();

        return response()->json([
            'messages' => $newMessages,
            'session_active' => $session->status === 'active',
        ]);
    }

    /**
     * تصفية الجلسات
     */
    public function filterSessions(Request $request)
    {
        $query = SupportSession::with('user', 'messages');

        // تصفية حسب الحالة
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // تصفية حسب الأولوية
        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // تصفية حسب الفئة
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // تصفية حسب موظف الدعم
        if ($request->has('agent') && $request->agent !== 'all') {
            if ($request->agent === 'unassigned') {
                $query->whereNull('support_agent_id');
            } else {
                $query->where('support_agent_id', $request->agent);
            }
        }

        $sessions = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('support.admin.sessions', compact('sessions'));
    }

    /**
     * إضافة رد على شكوى
     */
    public function addReply(Request $request, $sessionId)
    {
        $request->validate([
            'reply' => 'required|string|max:2000',
            'status' => 'nullable|in:active,closed',
        ]);

        $session = SupportSession::findOrFail($sessionId);

        // تعيين الجلسة للموظف إذا لم تكن معينة
        if (!$session->support_agent_id) {
            $session->update(['support_agent_id' => Auth::id()]);
        }

        // إنشاء رسالة الرد
        ChatMessage::create([
            'session_id' => $session->id,
            'sender_id' => Auth::id(),
            'message' => $request->reply,
            'is_read' => false,
        ]);

        // تحديث حالة الجلسة إذا تم تحديدها
        if ($request->has('status')) {
            $session->update([
                'status' => $request->status,
                'ended_at' => $request->status === 'closed' ? now() : null,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => ChatMessage::with('sender')->latest()->first(),
            ]);
        }

        return redirect()->back()->with('success', 'تم إضافة الرد بنجاح');
    }

    /**
     * عرض التقارير والإحصائيات
     */
    public function reports()
    {
        // إحصائيات شهرية
        $monthlyStats = SupportSession::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as month,
            COUNT(*) as total,
            SUM(CASE WHEN status = "closed" THEN 1 ELSE 0 END) as closed,
            SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active
        ')
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        // إحصائيات حسب الفئة
        $categoryStats = SupportSession::selectRaw('
            category,
            COUNT(*) as count
        ')
        ->groupBy('category')
        ->get();

        // إحصائيات حسب الأولوية
        $priorityStats = SupportSession::selectRaw('
            priority,
            COUNT(*) as count
        ')
        ->groupBy('priority')
        ->get();

        // متوسط وقت الاستجابة
        $avgResponseTime = ChatMessage::selectRaw('
            AVG(TIMESTAMPDIFF(MINUTE, 
                (SELECT created_at FROM chat_messages cm2 
                 WHERE cm2.session_id = chat_messages.session_id 
                 AND cm2.sender_id != chat_messages.sender_id 
                 ORDER BY cm2.created_at ASC LIMIT 1),
                chat_messages.created_at
            )) as avg_minutes
        ')
        ->whereNotNull('support_agent_id')
        ->first();

        return view('support.admin.reports', compact(
            'monthlyStats',
            'categoryStats',
            'priorityStats',
            'avgResponseTime'
        ));
    }

    /**
     * عرض قوالب الردود الجاهزة
     */
    public function replyTemplates()
    {
        $templates = ReplyTemplate::with('creator')
            ->orderBy('category')
            ->orderBy('title')
            ->get();

        return view('support.admin.reply-templates', compact('templates'));
    }

    /**
     * إنشاء قالب رد جديد
     */
    public function createReplyTemplate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
        ]);

        ReplyTemplate::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'تم إنشاء قالب الرد بنجاح');
    }

    /**
     * تحديث قالب رد
     */
    public function updateReplyTemplate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
        ]);

        $template = ReplyTemplate::findOrFail($id);
        $template->update([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
        ]);

        return redirect()->back()->with('success', 'تم تحديث قالب الرد بنجاح');
    }

    /**
     * حذف قالب رد
     */
    public function deleteReplyTemplate($id)
    {
        $template = ReplyTemplate::findOrFail($id);
        $template->delete();

        return redirect()->back()->with('success', 'تم حذف قالب الرد بنجاح');
    }

    /**
     * الحصول على قوالب الردود كـ JSON
     */
    public function getReplyTemplatesJson()
    {
        $templates = ReplyTemplate::select('id', 'title', 'content', 'category')
            ->orderBy('category')
            ->orderBy('title')
            ->get();

        return response()->json($templates);
    }
}
