@extends('layouts.app')

@section('title', 'تفاصيل جلسة الدعم')

@section('styles')
<style>
    .chat-container {
        height: 500px;
        overflow-y: auto;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
    }

    .message {
        margin-bottom: 1rem;
    }

    .message-content {
        padding: 0.75rem 1rem;
        border-radius: 12px;
        max-width: 70%;
        position: relative;
    }

    .message-user {
        margin-left: auto;
    }

    .message-agent {
        margin-right: auto;
    }

    .message-user .message-content {
        background: #3358e6;
        color: white;
        border-bottom-left-radius: 2px;
    }

    .message-agent .message-content {
        background: white;
        color: #333;
        border-bottom-right-radius: 2px;
    }

    .message-time {
        font-size: 0.75rem;
        opacity: 0.7;
        margin-top: 0.25rem;
    }

    .session-info-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .priority-badge {
        padding: 0.25rem 0.75rem;
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
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('support.agent.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right"></i> العودة للوحة التحكم
            </a>
            <h1 class="mt-2">جلسة #{{ $session->id }}</h1>
        </div>
        @if ($session->status === 'active')
            <form action="{{ route('support.agent.close', $session->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من إغلاق هذه الجلسة؟ سيتم حذف جميع الرسائل.');">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-x-circle"></i> إغلاق الجلسة
                </button>
            </form>
        @endif
    </div>

    <div class="row">
        <!-- معلومات الجلسة -->
        <div class="col-lg-4">
            <div class="session-info-card">
                <h5 class="mb-3">معلومات الجلسة</h5>
                <div class="mb-3">
                    <label class="text-muted small">الموضوع</label>
                    <div class="fw-bold">{{ $session->subject }}</div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">المستخدم</label>
                    <div>
                        <i class="bi bi-person"></i> {{ $session->user->name }}
                        <br>
                        <small class="text-muted">{{ $session->user->email }}</small>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">الأولوية</label>
                    <div>
                        <span class="priority-badge priority-{{ $session->priority }}">
                            {{ $session->priority === 'urgent' ? 'عاجلة' : 
                               ($session->priority === 'high' ? 'عالية' : 
                               ($session->priority === 'medium' ? 'متوسطة' : 'منخفضة')) }}
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">الفئة</label>
                    <div>{{ $session->category ?? 'غير محدد' }}</div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">تاريخ الإنشاء</label>
                    <div>{{ $session->created_at->format('Y-m-d H:i') }}</div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">الحالة</label>
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
                <div class="mb-3">
                    <label class="text-muted small">موظف الدعم</label>
                    <div>
                        @if ($session->support_agent_id)
                            {{ $session->supportAgent->name ?? 'غير محدد' }}
                        @else
                            <span class="text-muted">غير معين</span>
                            @if ($session->status === 'active')
                                <form action="{{ route('support.agent.assign', $session->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">
                                        <i class="bi bi-person-plus"></i> تعيين لي
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
                <div>
                    <label class="text-muted small">عدد الرسائل</label>
                    <div>{{ $session->messages->count() }}</div>
                </div>
            </div>
        </div>

        <!-- الدردشة -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">المحادثة</h5>
                        <span class="badge bg-info">{{ $session->messages->count() }} رسالة</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chat-container" id="chat-messages">
                        @if ($session->messages->count() > 0)
                            @foreach ($session->messages as $message)
                                <div class="message {{ $message->sender_id === $session->user_id ? 'message-user' : 'message-agent' }}">
                                    <div class="message-content">
                                        <div>{{ $message->message }}</div>
                                        <div class="message-time">
                                            {{ $message->created_at->format('H:i') }}
                                            @if ($message->sender_id === $session->user_id)
                                                | {{ $session->user->name }}
                                            @else
                                                | {{ $message->sender->name ?? 'موظف الدعم' }}
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
                        <form action="{{ route('support.agent.send', $session->id) }}" method="POST" class="mt-3" id="message-form">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="message" id="message-input" 
                                       placeholder="اكتب رسالتك هنا..." required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> إرسال
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let lastMessageId = {{ $session->messages->last()->id ?? 0 }};

    // تحديث الرسائل تلقائياً كل 3 ثواني
    setInterval(function() {
        fetch('{{ route('support.agent.messages', $session->id) }}?last_message_id=' + lastMessageId)
            .then(response => response.json())
            .then(data => {
                if (data.messages.length > 0) {
                    data.messages.forEach(message => {
                        const isUser = message.sender_id === {{ $session->user_id }};
                        const messageHtml = `
                            <div class="message ${isUser ? 'message-user' : 'message-agent'}">
                                <div class="message-content">
                                    <div>${message.message}</div>
                                    <div class="message-time">
                                        ${message.created_at}
                                        | ${isUser ? '{{ $session->user->name }}' : message.sender.name}
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
</script>
@endsection
