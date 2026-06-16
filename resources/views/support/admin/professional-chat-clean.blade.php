@extends('layouts.app')

@section('title', 'الدردشة الاحترافية')

@section('styles')
<style>
    .chat-wrapper {
        height: calc(100vh - 150px);
        display: flex;
        flex-direction: column;
        background: #f5f7fa;
        border-radius: 12px;
        overflow: hidden;
    }

    .chat-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
        background: #f5f7fa;
    }

    .message {
        display: flex;
        margin-bottom: 1.5rem;
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .message.user {
        justify-content: flex-end;
    }

    .message.agent {
        justify-content: flex-start;
    }

    .message-content {
        max-width: 70%;
        padding: 1rem 1.25rem;
        border-radius: 18px;
        position: relative;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .message.user .message-content {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-left-radius: 4px;
    }

    .message.agent .message-content {
        background: white;
        color: #333;
        border-bottom-right-radius: 4px;
    }

    .message-time {
        font-size: 0.75rem;
        opacity: 0.7;
        margin-top: 0.5rem;
    }

    .message-sender {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .chat-input {
        background: white;
        padding: 1.5rem;
        border-top: 1px solid #e8e8e8;
    }

    .chat-input .input-group {
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .chat-input .form-control {
        border: none;
        padding: 1rem 1.5rem;
        font-size: 1rem;
    }

    .chat-input .btn-send {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0 1.5rem;
        color: white;
        font-weight: 600;
    }

    .chat-input .btn-send:hover {
        background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
        color: white;
    }

    .session-info {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }

    .info-item {
        margin-bottom: 1rem;
    }

    .info-label {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-weight: 600;
        color: #333;
    }

    .priority-badge {
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .priority-urgent {
        background: #fee;
        color: #c00;
    }

    .priority-high {
        background: #fff3e0;
        color: #e65100;
    }

    .priority-medium {
        background: #e3f2fd;
        color: #1976d2;
    }

    .priority-low {
        background: #e8f5e9;
        color: #388e3c;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .emoji-picker {
        position: absolute;
        bottom: 100%;
        right: 0;
        background: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        display: none;
        z-index: 100;
    }

    .emoji-picker.show {
        display: block;
    }

    .emoji-grid {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 0.5rem;
    }

    .emoji-btn {
        font-size: 1.5rem;
        padding: 0.25rem;
        border: none;
        background: none;
        cursor: pointer;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .emoji-btn:hover {
        background: #f0f0f0;
    }

    .reply-templates {
        position: absolute;
        bottom: 100%;
        right: 0;
        background: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        display: none;
        z-index: 100;
        min-width: 300px;
        max-height: 400px;
        overflow-y: auto;
    }

    .reply-templates.show {
        display: block;
    }

    .template-item {
        padding: 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
        margin-bottom: 0.5rem;
    }

    .template-item:hover {
        background: #f0f0f0;
    }

    .template-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .template-content {
        font-size: 0.9rem;
        color: #666;
    }

    .status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 0.5rem;
    }

    .status-online {
        background: #4caf50;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- معلومات الجلسة -->
        <div class="col-lg-4">
            <div class="session-info">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">معلومات الجلسة</h5>
                    <a href="{{ route('support.agent.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-right"></i> العودة
                    </a>
                </div>

                <div class="info-item">
                    <div class="info-label">رقم الجلسة</div>
                    <div class="info-value">#{{ $session->id }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">الموضوع</div>
                    <div class="info-value">{{ $session->subject }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">المستخدم</div>
                    <div class="info-value">
                        <span class="status-indicator status-online"></span>
                        {{ $session->user->name }}
                    </div>
                    <div class="text-muted small">{{ $session->user->email }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">الأولوية</div>
                    <div>
                        <span class="priority-badge priority-{{ $session->priority }}">
                            {{ $session->priority === 'urgent' ? 'عاجلة' :
                               ($session->priority === 'high' ? 'عالية' :
                               ($session->priority === 'medium' ? 'متوسطة' : 'منخفضة')) }}
                        </span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">الفئة</div>
                    <div class="info-value">{{ $session->category ?? 'غير محدد' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">تاريخ الإنشاء</div>
                    <div class="info-value">{{ $session->created_at->format('Y-m-d H:i') }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">الحالة</div>
                    <div>
                        @if ($session->status === 'active')
                            <span class="badge bg-success">نشطة</span>
                        @elseif ($session->status === 'closed')
                            <span class="badge bg-danger">مغلقة</span>
                        @else
                            <span class="badge bg-warning">ملغاة</span>
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">موظف الدعم</div>
                    <div class="info-value">
                        @if ($session->support_agent_id)
                            {{ $session->supportAgent->name ?? 'غير محدد' }}
                        @else
                            <span class="text-muted">غير معين</span>
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">عدد الرسائل</div>
                    <div class="info-value">{{ $session->messages->count() }}</div>
                </div>

                <div class="action-buttons mt-4">
                    @if ($session->status === 'active')
                        @if (!$session->support_agent_id)
                            <form action="{{ route('support.agent.assign', $session->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-action btn-success">
                                    <i class="bi bi-person-plus"></i> تعيين لي
                                </button>
                            </form>
                        @endif
                        <button class="btn btn-action btn-danger" onclick="closeSession({{ $session->id }})">
                            <i class="bi bi-x-circle"></i> إغلاق الجلسة
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- الدردشة -->
        <div class="col-lg-8">
            <div class="chat-wrapper">
                <div class="chat-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">{{ $session->subject }}</h5>
                            <small class="text-white-50">جلسة #{{ $session->id }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-white text-primary">{{ $session->messages->count() }} رسالة</span>
                            <span class="badge bg-white text-primary">
                                <i class="bi bi-clock"></i> {{ $session->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="chat-messages" id="chat-messages">
                    @if ($session->messages->count() > 0)
                        @foreach ($session->messages as $message)
                            <div class="message {{ $message->sender_id === $session->user_id ? 'user' : 'agent' }}">
                                <div class="message-content">
                                    <div class="message-sender">
                                        {{ $message->sender_id === $session->user_id ? $session->user->name : ($message->sender->name ?? 'موظف الدعم') }}
                                    </div>
                                    <div>{{ $message->message }}</div>
                                    <div class="message-time">
                                        {{ $message->created_at->format('H:i') }}
                                        @if ($message->is_read && $message->sender_id === auth()->id())
                                            <i class="bi bi-check2-all ms-1"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-chat-square-text" style="font-size: 3rem;"></i>
                            <p class="mt-3">لا توجد رسائل بعد</p>
                        </div>
                    @endif
                </div>

                @if ($session->status === 'active')
                    <div class="chat-input">
                        <form action="{{ route('support.agent.send', $session->id) }}" method="POST" id="message-form">
                            @csrf
                            <div class="input-group position-relative">
                                <button type="button" class="btn btn-light border" onclick="toggleEmojiPicker()">
                                    <i class="bi bi-emoji-smile"></i>
                                </button>
                                <button type="button" class="btn btn-light border" onclick="toggleReplyTemplates()">
                                    <i class="bi bi-chat-quote"></i>
                                </button>
                                <input type="text" class="form-control" name="message" id="message-input"
                                       placeholder="اكتب رسالتك هنا..." required autocomplete="off">
                                <button type="submit" class="btn-send">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>

                            <!-- منتقي الإيموجي -->
                            <div class="emoji-picker" id="emoji-picker">
                                <div class="emoji-grid">
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('😀')">😀</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('😊')">😊</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('😂')">😂</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('🤔')">🤔</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('👍')">👍</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('👎')">👎</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('❤️')">❤️</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('✅')">✅</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('🎉')">🎉</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('🙏')">🙏</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('💪')">💪</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('🤝')">🤝</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('📝')">📝</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('🔍')">🔍</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('💡')">💡</button>
                                    <button type="button" class="emoji-btn" onclick="insertEmoji('⭐')">⭐</button>
                                </div>
                            </div>

                            <!-- قوالب الردود -->
                            <div class="reply-templates" id="reply-templates">
                                <h6 class="mb-3">قوالب الردود</h6>
                                @if ($replyTemplates->count() > 0)
                                    @foreach ($replyTemplates as $template)
                                        <div class="template-item" onclick="useTemplate('{{ $template->content }}')">
                                            <div class="template-title">{{ $template->title }}</div>
                                            <div class="template-content">{{ Str::limit($template->content, 100) }}</div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted text-center">لا توجد قوالب رد</p>
                                @endif
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let lastMessageId = {{ $session->messages->last()->id ?? 0 }};
    let isTyping = false;

    // تحديث الرسائل تلقائياً كل 3 ثواني
    setInterval(function() {
        fetch('{{ route('support.agent.messages', $session->id) }}?last_message_id=' + lastMessageId)
            .then(response => response.json())
            .then(data => {
                if (data.messages.length > 0) {
                    data.messages.forEach(message => {
                        const isUser = message.sender_id === {{ $session->user_id }};
                        const messageHtml = `
                            <div class="message ${isUser ? 'user' : 'agent'}">
                                <div class="message-content">
                                    <div class="message-sender">
                                        ${isUser ? '{{ $session->user->name }}' : message.sender.name}
                                    </div>
                                    <div>${message.message}</div>
                                    <div class="message-time">
                                        ${message.created_at}
                                        ${message.is_read && !isUser ? '<i class="bi bi-check2-all ms-1"></i>' : ''}
                                    </div>
                                </div>
                            </div>
                        `;

                        document.getElementById('chat-messages').insertAdjacentHTML('beforeend', messageHtml);
                        lastMessageId = message.id;
                    });

                    // التمرير إلى أسفل المحادثة
                    const chatMessages = document.getElementById('chat-messages');
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }

                // التحقق من حالة الجلسة
                if (!data.session_active) {
                    alert('تم إغلاق الجلسة.');
                    window.location.href = '{{ route('support.agent.dashboard') }}';
                }
            });
    }, 3000);

    // إرسال الرسالة عبر AJAX
    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();

        if (message) {
            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageInput.value = '';
                } else {
                    alert(data.message || 'حدث خطأ أثناء إرسال الرسالة');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء إرسال الرسالة');
            });
        }
    });

    // التمرير إلى أسفل المحادثة عند تحميل الصفحة
    window.addEventListener('load', function() {
        const chatMessages = document.getElementById('chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    // إظهار/إخفاء منتقي الإيموجي
    function toggleEmojiPicker() {
        const picker = document.getElementById('emoji-picker');
        picker.classList.toggle('show');
    }

    // إدراج إيموجي في حقل الإدخال
    function insertEmoji(emoji) {
        const input = document.getElementById('message-input');
        input.value += emoji;
        input.focus();
    }

    // إظهار/إخفاء قوالب الردود
    function toggleReplyTemplates() {
        const templates = document.getElementById('reply-templates');
        templates.classList.toggle('show');
    }

    // استخدام قالب رد
    function useTemplate(content) {
        const input = document.getElementById('message-input');
        input.value = content;
        input.focus();
        document.getElementById('reply-templates').classList.remove('show');
    }

    // إغلاق الجلسة
    function closeSession(sessionId) {
        if (confirm('هل أنت متأكد من أنك تريد إغلاق هذه الجلسة؟')) {
            fetch(`/support/agent/close/${sessionId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('تم إغلاق الجلسة بنجاح');
                    window.location.href = '{{ route('support.agent.dashboard') }}';
                } else {
                    alert(data.message || 'حدث خطأ أثناء إغلاق الجلسة');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء إغلاق الجلسة');
            });
        }
    }

    // إغلاق القوائم عند النقر خارجها
    document.addEventListener('click', function(e) {
        const emojiPicker = document.getElementById('emoji-picker');
        const replyTemplates = document.getElementById('reply-templates');

        if (!e.target.closest('.emoji-picker') && !e.target.closest('[onclick="toggleEmojiPicker()"]')) {
            emojiPicker.classList.remove('show');
        }

        if (!e.target.closest('.reply-templates') && !e.target.closest('[onclick="toggleReplyTemplates()"]')) {
            replyTemplates.classList.remove('show');
        }
    });
</script>
@endsection
