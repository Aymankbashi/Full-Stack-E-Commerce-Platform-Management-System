@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">الدعم الفني</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- نموذج إنشاء جلسة جديدة -->
                    <div class="mb-4">
                        <h5 class="mb-3">إنشاء جلسة دعم جديدة</h5>
                        <form action="{{ route('support.create') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="subject" class="form-label">عنوان المشكلة</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">فئة المشكلة</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">اختر الفئة</option>
                                    <option value="technical">مشاكل تقنية</option>
                                    <option value="billing">مشاكل في الفواتير</option>
                                    <option value="account">مشاكل في الحساب</option>
                                    <option value="other">أخرى</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="priority" class="form-label">أولوية المشكلة</label>
                                <select class="form-select" id="priority" name="priority" required>
                                    <option value="low">منخفضة</option>
                                    <option value="medium" selected>متوسطة</option>
                                    <option value="high">عالية</option>
                                    <option value="urgent">عاجلة</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">وصف المشكلة</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">بدء المحادثة</button>
                        </form>
                    </div>

                    <!-- الجلسات النشطة -->
                    @if ($activeSessions->count() > 0)
                        <div>
                            <h5 class="mb-3">جلسات الدعم النشطة</h5>
                            <div class="list-group">
                                @foreach ($activeSessions as $session)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $session->subject }}</h6>
                                            <small class="text-muted">{{ $session->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1 text-truncate">{{ $session->messages->last()->message ?? 'لا توجد رسائل' }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                الفئة: {{ $session->category ?? 'غير محدد' }} |
                                                الأولوية: 
                                                @if($session->priority == 'low') منخفضة
                                                @elseif($session->priority == 'medium') متوسطة
                                                @elseif($session->priority == 'high') عالية
                                                @elseif($session->priority == 'urgent') عاجلة
                                                @endif
                                            </small>
                                            <a href="{{ route('support.chat', $session->id) }}" class="btn btn-sm btn-primary">فتح المحادثة</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
