@extends('layouts.app')

@section('title', 'لوحة تحكم الدعم الفني')

@section('styles')
<style>
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #e8e8e8;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .session-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #e8e8e8;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .session-card:hover {
        border-color: #3358e6;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-active {
        background: #e8f5e9;
        color: #388e3c;
    }

    .status-closed {
        background: #ffebee;
        color: #c62828;
    }

    .status-pending {
        background: #fff3e0;
        color: #e65100;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>لوحة تحكم الدعم الفني</h1>
        <div>
            <a href="{{ route('support.reports') }}" class="btn btn-outline-primary">
                <i class="bi bi-graph-up"></i> التقارير والإحصائيات
            </a>
        </div>
    </div>

    <!-- الإحصائيات -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="stat-card">
                <div class="stat-icon" style="background: #e3f2fd; color: #1976d2;">
                    <i class="bi bi-ticket-detailed"></i>
                </div>
                <div class="stat-number">{{ $stats['total_sessions'] }}</div>
                <div class="text-muted">إجمالي الجلسات</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card">
                <div class="stat-icon" style="background: #e8f5e9; color: #388e3c;">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <div class="stat-number">{{ $stats['active_sessions'] }}</div>
                <div class="text-muted">نشطة</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card">
                <div class="stat-icon" style="background: #ffebee; color: #c62828;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-number">{{ $stats['closed_sessions'] }}</div>
                <div class="text-muted">مغلقة</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card">
                <div class="stat-icon" style="background: #fff3e0; color: #e65100;">
                    <i class="bi bi-clock"></i>
                </div>
                <div class="stat-number">{{ $stats['pending_sessions'] }}</div>
                <div class="text-muted">في الانتظار</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card">
                <div class="stat-icon" style="background: #fff3e0; color: #e65100;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-number">{{ $stats['high_priority'] }}</div>
                <div class="text-muted">أولوية عالية</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card">
                <div class="stat-icon" style="background: #fee; color: #c00;">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="stat-number">{{ $stats['urgent_priority'] }}</div>
                <div class="text-muted">عاجلة</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- الجلسات النشطة -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">الجلسات النشطة</h5>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary" onclick="filterSessions('all')">الكل</button>
                            <button class="btn btn-sm btn-outline-primary" onclick="filterSessions('unassigned')">غير معينة</button>
                            <button class="btn btn-sm btn-outline-primary" onclick="filterSessions('my')">جلساتي</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if ($activeSessions->count() > 0)
                        @foreach ($activeSessions as $session)
                            <div class="session-card p-3" onclick="viewSession({{ $session->id }})">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">{{ $session->subject }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> {{ $session->user->name }}
                                            | <i class="bi bi-clock"></i> {{ $session->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <span class="priority-badge priority-{{ $session->priority }}">
                                            {{ $session->priority === 'urgent' ? 'عاجلة' : 
                                               ($session->priority === 'high' ? 'عالية' : 
                                               ($session->priority === 'medium' ? 'متوسطة' : 'منخفضة')) }}
                                        </span>
                                        <span class="status-badge {{ $session->support_agent_id ? 'status-active' : 'status-pending' }}">
                                            {{ $session->support_agent_id ? 'معينة' : 'في الانتظار' }}
                                        </span>
                                    </div>
                                </div>
                                @if ($session->messages->last())
                                    <p class="mb-2 text-muted small">
                                        <i class="bi bi-chat-left"></i> {{ Str::limit($session->messages->last()->message, 100) }}
                                    </p>
                                @endif
                                <div class="d-flex gap-2 mt-2">
                                    @if ($session->support_agent_id)
                                        <a href="{{ route('support.agent.professional-chat', $session->id) }}" class="btn btn-sm btn-primary" onclick="event.stopPropagation()">
                                            <i class="bi bi-chat-dots"></i> الرد
                                        </a>
                                    @endif
                                    @if (!$session->support_agent_id)
                                        <form action="{{ route('support.agent.assign', $session->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-person-plus"></i> تعيين لي
                                            </button>
                                        </form>
                                    @endif
                                    <button class="btn btn-sm btn-danger" onclick="closeSession({{ $session->id }})">
                                        <i class="bi bi-x-circle"></i> إغلاق
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        {{ $activeSessions->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">لا توجد جلسات نشطة حالياً</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- جلساتي -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">جلساتي النشطة</h5>
                </div>
                <div class="card-body p-0">
                    @if ($mySessions->count() > 0)
                        @foreach ($mySessions as $session)
                            <div class="session-card p-3" onclick="viewSession({{ $session->id }})">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">{{ $session->subject }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> {{ $session->user->name }}
                                        </small>
                                    </div>
                                    <span class="priority-badge priority-{{ $session->priority }}">
                                        {{ $session->priority === 'urgent' ? 'عاجلة' : 
                                           ($session->priority === 'high' ? 'عالية' : 
                                           ($session->priority === 'medium' ? 'متوسطة' : 'منخفضة')) }}
                                    </span>
                                </div>
                                @if ($session->messages->last())
                                    <p class="mb-0 text-muted small">
                                        <i class="bi bi-chat-left"></i> {{ Str::limit($session->messages->last()->message, 80) }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">لا توجد جلسات معينة لك حالياً</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentSessionId = null;

    function viewSession(sessionId) {
        currentSessionId = sessionId;
        // إظهار صندوق الدردشة
        const chatModal = document.getElementById('chatModal');
        const modalBackdrop = document.getElementById('modalBackdrop');
        if (chatModal && modalBackdrop) {
            chatModal.classList.add('show');
            modalBackdrop.classList.add('show');
            // تحميل الرسائل
            loadChatMessages(sessionId);
        }
    }

    function loadChatMessages(sessionId) {
        // تحميل الرسائل عبر AJAX
        fetch(`/support/agent/messages/${sessionId}`)
            .then(response => response.json())
            .then(data => {
                if (data.messages) {
                    const messagesContainer = document.getElementById('chatMessages');
                    messagesContainer.innerHTML = data.messages.map(msg => `
                        <div class="message ${msg.sender_id === {{ auth()->id() }} ? 'agent' : 'user'}">
                            <div class="message-content">
                                <div class="message-sender">${msg.sender_name}</div>
                                <div>${msg.message}</div>
                                <div class="message-time">${msg.time}</div>
                            </div>
                        </div>
                    `).join('');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function closeChatModal() {
        const chatModal = document.getElementById('chatModal');
        const modalBackdrop = document.getElementById('modalBackdrop');
        if (chatModal && modalBackdrop) {
            chatModal.classList.remove('show');
            modalBackdrop.classList.remove('show');
        }
    }

    function sendMessage(sessionId) {
        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value.trim();
        
        if (message) {
            const formData = new FormData();
            formData.append('message', message);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            fetch(`/support/agent/send/${sessionId}`, {
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
                    loadChatMessages(sessionId);
                } else {
                    alert(data.message || 'حدث خطأ أثناء إرسال الرسالة');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء إرسال الرسالة');
            });
        }
    }

    function filterSessions(type) {
        let url = '{{ route('support.filter') }}';
        if (type === 'unassigned') {
            url += '?agent=unassigned';
        } else if (type === 'my') {
            url += '?agent={{ auth()->id() }}';
        }
        window.location.href = url;
    }

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
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء إغلاق الجلسة');
            });
        }
    }
</script>
@endsection

<!-- صندوق الدردشة -->
<div class="modal-backdrop fade" id="modalBackdrop" onclick="closeChatModal()"></div>
<div class="modal fade" id="chatModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">الدردشة</h5>
                <button type="button" class="close" onclick="closeChatModal()">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="chatMessages" class="chat-messages" style="max-height: 400px; overflow-y: auto;">
                    <!-- سيتم تحميل الرسائل هنا -->
                </div>
            </div>
            <div class="modal-footer">
                <div class="input-group">
                    <input type="text" id="messageInput" class="form-control" placeholder="اكتب رسالتك هنا...">
                    <button class="btn btn-primary" onclick="sendMessage(currentSessionId)">إرسال</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1050;
    width: 100%;
}

.modal-content {
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    overflow: hidden;
}

.modal-header {
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    margin: 0;
    font-size: 1.25rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
}

.modal-header .close {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    opacity: 0.8;
    transition: opacity 0.2s;
}

.modal-header .close:hover {
    opacity: 1;
}

.modal.show {
    display: block !important;
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1040;
    display: none;
}

.modal-backdrop.show {
    display: block !important;
}

.chat-messages {
    padding: 1rem;
    background: #f5f7fa;
    border-radius: 8px;
}

.message {
    margin-bottom: 1rem;
    padding: 0.5rem;
}

.message.agent {
    text-align: left;
}

.message.user {
    text-align: right;
}

.message-content {
    display: inline-block;
    max-width: 70%;
    padding: 0.75rem;
    border-radius: 12px;
}

.message.agent .message-content {
    background: #e3f2fd;
    color: #1976d2;
}

.message.user .message-content {
    background: #667eea;
    color: white;
}

.message-sender {
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
    opacity: 0.7;
}

.message-time {
    font-size: 0.75rem;
    margin-top: 0.25rem;
    opacity: 0.7;
}
</style>
