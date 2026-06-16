@extends('layouts.app')

@section('title', 'التقارير والإحصائيات')

@section('styles')
<style>
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #e8e8e8;
    }

    .chart-container {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #e8e8e8;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #3358e6;
        margin-bottom: 0.5rem;
    }

    .progress {
        height: 25px;
        border-radius: 12px;
        background: #f0f0f0;
    }

    .progress-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>التقارير والإحصائيات</h1>
        <a href="{{ route('support.agent.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right"></i> العودة للوحة التحكم
        </a>
    </div>

    <!-- متوسط وقت الاستجابة -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card text-center">
                <div class="stat-number">
                    {{ number_format($avgResponseTime->avg_minutes ?? 0, 1) }}
                </div>
                <div class="text-muted">متوسط وقت الاستجابة (دقائق)</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <div class="stat-number">
                    {{ $monthlyStats->sum('total') }}
                </div>
                <div class="text-muted">إجمالي الجلسات هذا العام</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <div class="stat-number">
                    {{ number_format(($monthlyStats->sum('closed') / max($monthlyStats->sum('total'), 1)) * 100, 1) }}%
                </div>
                <div class="text-muted">نسبة الجلسات المغلقة</div>
            </div>
        </div>
    </div>

    <!-- إحصائيات شهرية -->
    <div class="chart-container">
        <h5 class="mb-4">الإحصائيات الشهرية</h5>
        @if ($monthlyStats->count() > 0)
            @foreach ($monthlyStats as $stat)
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>{{ $stat->month }}</span>
                        <span>
                            {{ $stat->closed }}/{{ $stat->total }} جلسة مغلقة
                            ({{ number_format(($stat->closed / max($stat->total, 1)) * 100, 1) }}%)
                        </span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: {{ ($stat->closed / max($stat->total, 1)) * 100 }}%">
                            {{ number_format(($stat->closed / max($stat->total, 1)) * 100, 1) }}%
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted text-center py-3">لا توجد بيانات متاحة</p>
        @endif
    </div>

    <div class="row">
        <!-- إحصائيات حسب الفئة -->
        <div class="col-md-6">
            <div class="chart-container">
                <h5 class="mb-4">الجلسات حسب الفئة</h5>
                @if ($categoryStats->count() > 0)
                    @foreach ($categoryStats as $stat)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>
                                    @if ($stat->category === 'technical')
                                        مشاكل تقنية
                                    @elseif ($stat->category === 'billing')
                                        مشاكل في الفواتير
                                    @elseif ($stat->category === 'account')
                                        مشاكل في الحساب
                                    @elseif ($stat->category === 'order')
                                        مشاكل في الطلبات
                                    @else
                                        أخرى
                                    @endif
                                </span>
                                <span>{{ $stat->count }} جلسة</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" style="width: {{ ($stat->count / max($categoryStats->sum('count'), 1)) * 100 }}%">
                                    {{ number_format(($stat->count / max($categoryStats->sum('count'), 1)) * 100, 1) }}%
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3">لا توجد بيانات متاحة</p>
                @endif
            </div>
        </div>

        <!-- إحصائيات حسب الأولوية -->
        <div class="col-md-6">
            <div class="chart-container">
                <h5 class="mb-4">الجلسات حسب الأولوية</h5>
                @if ($priorityStats->count() > 0)
                    @foreach ($priorityStats as $stat)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>
                                    @if ($stat->priority === 'urgent')
                                        عاجلة
                                    @elseif ($stat->priority === 'high')
                                        عالية
                                    @elseif ($stat->priority === 'medium')
                                        متوسطة
                                    @else
                                        منخفضة
                                    @endif
                                </span>
                                <span>{{ $stat->count }} جلسة</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar 
                                    @if ($stat->priority === 'urgent')
                                        bg-danger
                                    @elseif ($stat->priority === 'high')
                                        bg-warning
                                    @elseif ($stat->priority === 'medium')
                                        bg-info
                                    @else
                                        bg-success
                                    @endif
                                " style="width: {{ ($stat->count / max($priorityStats->sum('count'), 1)) * 100 }}%">
                                    {{ number_format(($stat->count / max($priorityStats->sum('count'), 1)) * 100, 1) }}%
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3">لا توجد بيانات متاحة</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
