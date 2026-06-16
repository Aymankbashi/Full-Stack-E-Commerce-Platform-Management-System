@extends('layouts.app')

@section('title', 'قوالب الردود الجاهزة')

@section('styles')
<style>
    .template-card {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
    }

    .template-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .template-content {
        max-height: 150px;
        overflow-y: auto;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
    }

    .category-badge {
        background: #e3f2fd;
        color: #1976d2;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>قوالب الردود الجاهزة</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
            <i class="bi bi-plus-circle"></i> إنشاء قالب جديد
        </button>
    </div>

    @if ($templates->count() > 0)
        <div class="row">
            @foreach ($templates as $template)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card template-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $template->title }}</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button class="dropdown-item" onclick="useTemplate({{ $template->id }})">
                                                <i class="bi bi-check-circle"></i> استخدام
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" onclick="editTemplate({{ $template->id }})">
                                                <i class="bi bi-pencil"></i> تعديل
                                            </button>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-danger" onclick="deleteTemplate({{ $template->id }})">
                                                <i class="bi bi-trash"></i> حذف
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @if ($template->category)
                                <span class="category-badge mb-2">{{ $template->category }}</span>
                            @endif

                            <div class="template-content mt-2">
                                {{ $template->content }}
                            </div>

                            <div class="mt-3 text-muted small">
                                <i class="bi bi-person"></i> {{ $template->creator->name ?? 'غير محدد' }}
                                <span class="mx-2">|</span>
                                <i class="bi bi-calendar"></i> {{ $template->created_at->format('Y-m-d') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-file-earmark-text" style="font-size: 4rem; color: #dee2e6;"></i>
            <h3 class="mt-3 text-muted">لا توجد قوالب ردود بعد</h3>
            <p class="text-muted">ابدأ بإنشاء قالب رد جديد لتسهيل العمل</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
                <i class="bi bi-plus-circle"></i> إنشاء قالب جديد
            </button>
        </div>
    @endif
</div>

<!-- Modal إنشاء قالب جديد -->
<div class="modal fade" id="createTemplateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إنشاء قالب رد جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('support.agent.reply-templates.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">عنوان القالب</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الفئة</label>
                        <input type="text" class="form-control" name="category" placeholder="مثال: مشاكل تقنية، استفسارات عامة">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">محتوى القالب</label>
                        <textarea class="form-control" name="content" rows="6" required></textarea>
                        <small class="text-muted">يمكنك استخدام المتغيرات مثل {name} لاسم المستخدم</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ القالب</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal تعديل قالب -->
<div class="modal fade" id="editTemplateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل قالب الرد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="editTemplateForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="editTemplateId">
                    <div class="mb-3">
                        <label class="form-label">عنوان القالب</label>
                        <input type="text" class="form-control" name="title" id="editTemplateTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الفئة</label>
                        <input type="text" class="form-control" name="category" id="editTemplateCategory">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">محتوى القالب</label>
                        <textarea class="form-control" name="content" id="editTemplateContent" rows="6" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تحديث القالب</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // استخدام قالب
    function useTemplate(templateId) {
        fetch('{{ route('support.agent.reply-templates.json') }}')
            .then(response => response.json())
            .then(templates => {
                const template = templates.find(t => t.id === templateId);
                if (template) {
                    // تخزين القالب في localStorage لاستخدامه في صفحة الجلسة
                    localStorage.setItem('selectedTemplate', JSON.stringify(template));
                    window.location.href = '{{ route('support.agent.dashboard') }}';
                }
            });
    }

    // تعديل قالب
    function editTemplate(templateId) {
        fetch('{{ route('support.agent.reply-templates.json') }}')
            .then(response => response.json())
            .then(templates => {
                const template = templates.find(t => t.id === templateId);
                if (template) {
                    document.getElementById('editTemplateId').value = template.id;
                    document.getElementById('editTemplateTitle').value = template.title;
                    document.getElementById('editTemplateCategory').value = template.category || '';
                    document.getElementById('editTemplateContent').value = template.content;

                    const form = document.getElementById('editTemplateForm');
                    form.action = `{{ route('support.agent.reply-templates.update', '') }}/${templateId}`;

                    new bootstrap.Modal(document.getElementById('editTemplateModal')).show();
                }
            });
    }

    // حذف قالب
    function deleteTemplate(templateId) {
        if (confirm('هل أنت متأكد من حذف هذا القالب؟')) {
            fetch(`{{ route('support.agent.reply-templates.delete', '') }}/${templateId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
</script>
@endsection
