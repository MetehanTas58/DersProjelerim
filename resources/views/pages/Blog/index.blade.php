@extends('layouts.app.app')

@section('content')
<!-- Dashboard Header -->
<div class="row mb-3">
    <div class="col-md-8 col-sm-12">
        <h3 class="fw-bold text-dark mb-1">{{ __('messages.blog_news_list') }}</h3>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">
            {{ __('messages.blog_news_desc') }}
        </p>
    </div>
    <div class="col-md-4 col-sm-12 text-md-end mt-2 mt-md-0 d-flex justify-content-md-end align-items-center gap-2">
        <a href="{{ route('blog.new') }}">
            <button type="button" class="btn btn-success-gradient px-4 rounded-3 shadow-sm hover-scale">
                <i class="bi bi-plus-circle me-1.5"></i>{{ __('messages.add_new') }}
            </button>
        </a>
        <button type="button" class="btn btn-outline-primary px-3 rounded-3 editBlogBtn hover-scale" style="height: 38px;">
            <i class="bi bi-pencil me-1.5"></i>{{ __('messages.edit') }}
        </button>
        <button type="button" class="btn btn-outline-danger px-3 rounded-3 delBlogBtn hover-scale" style="height: 38px;">
            <i class="bi bi-trash me-1.5"></i>{{ __('messages.delete') }}
        </button>
    </div>
</div>

<!-- KPI Dashboard Statistics Row -->
<div class="row mb-4">
    <!-- Total Posts -->
    <div class="col-lg-3 col-sm-6 mb-3 mb-lg-0">
        <div class="card metric-card border-0 shadow-sm bg-gradient-blue text-white rounded-3 h-100 hover-lift">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-white-50 fw-semibold text-uppercase tracking-wider" style="font-size: 0.75rem;">Toplam İçerik</span>
                    <h2 class="mb-0 fw-bold mt-1">{{ $stats['total'] }}</h2>
                </div>
                <div class="metric-icon-bg bg-white-20 rounded-3 p-3">
                    <i class="bi bi-files fs-3 text-white"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Active Published -->
    <div class="col-lg-3 col-sm-6 mb-3 mb-lg-0">
        <div class="card metric-card border-0 shadow-sm bg-gradient-green text-white rounded-3 h-100 hover-lift">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-white-50 fw-semibold text-uppercase tracking-wider" style="font-size: 0.75rem;">Aktif Yayınlar</span>
                    <h2 class="mb-0 fw-bold mt-1">{{ $stats['active'] }}</h2>
                </div>
                <div class="metric-icon-bg bg-white-20 rounded-3 p-3">
                    <i class="bi bi-eye fs-3 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Posts -->
    <div class="col-lg-3 col-sm-6 mb-3 mb-sm-0">
        <div class="card metric-card border-0 shadow-sm bg-gradient-orange text-white rounded-3 h-100 hover-lift">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-white-50 fw-semibold text-uppercase tracking-wider" style="font-size: 0.75rem;">Blog Yazıları</span>
                    <h2 class="mb-0 fw-bold mt-1">{{ $stats['blog'] }}</h2>
                </div>
                <div class="metric-icon-bg bg-white-20 rounded-3 p-3">
                    <i class="bi bi-journal-text fs-3 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- News Bulletins -->
    <div class="col-lg-3 col-sm-6">
        <div class="card metric-card border-0 shadow-sm bg-gradient-purple text-white rounded-3 h-100 hover-lift">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-white-50 fw-semibold text-uppercase tracking-wider" style="font-size: 0.75rem;">Haber Bültenleri</span>
                    <h2 class="mb-0 fw-bold mt-1">{{ $stats['news'] }}</h2>
                </div>
                <div class="metric-icon-bg bg-white-20 rounded-3 p-3">
                    <i class="bi bi-newspaper fs-3 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="row">
    <div class="col-sm-12">
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-header border-0 d-flex flex-wrap justify-content-between align-items-center bg-white py-3 gap-3">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary-emphasis"><i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>İçerik Listesi</h5>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <!-- Type Filter -->
                    <div class="d-flex align-items-center">
                        <select id="filterType" class="form-select list-cmb type-cmb border-0 shadow-sm px-3 bg-light" style="width: 170px; border-radius: 8px; font-weight: 500; font-size: 0.85rem; height: 38px;">
                            <option value="0" selected>Tip: {{ __('messages.all') }}</option>
                            <option value="1">Tip: {{ __('messages.blog') }}</option>
                            <option value="2">Tip: {{ __('messages.news') }}</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="d-flex align-items-center">
                        <select id="filterStatus" class="form-select list-cmb status-cmb border-0 shadow-sm px-3 bg-light" style="width: 170px; border-radius: 8px; font-weight: 500; font-size: 0.85rem; height: 38px;">
                            <option value="1" selected>Durum: {{ __('messages.active') }}</option>
                            <option value="0">Durum: {{ __('messages.passive') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light-subtle px-4 py-3">
                <div class="table-responsive">
                    <table class="table align-middle w-100" id="blogTable">
                        <thead>
                            <tr>
                                <th class="border-0 px-3">{{ __('messages.title') }} / {{ __('messages.description') }}</th>
                                <th class="border-0" width="160px">{{ __('messages.type') }}</th>
                                <th class="border-0" width="160px">{{ __('messages.status') }}</th>
                                <th class="border-0 text-end px-3" width="180px">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    var checkInterval = setInterval(function () {
        if (app.loader !== undefined && app.loader !== null) {
            app.loader.setModule("Blog");
            clearInterval(checkInterval);
        }
    }, 500);
</script>

<style>
    /* Gradient Button Styling */
    .btn-success-gradient {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        border: none;
        color: white;
    }
    .btn-success-gradient:hover {
        background: linear-gradient(135deg, #157347 0%, #17b082 100%);
        color: white;
    }

    /* KPI Background Gradients */
    .bg-gradient-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }
    .bg-gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }
    .bg-gradient-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    .bg-gradient-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    /* KPI Icon Box Background overlay */
    .bg-white-20 {
        background-color: rgba(255, 255, 255, 0.2);
    }

    /* KPI Card animations */
    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
    }

    .hover-scale {
        transition: transform 0.2s ease;
    }
    .hover-scale:hover {
        transform: scale(1.03);
    }

    /* Modern layout of data table */
    #blogTable {
        border-collapse: separate !important;
        border-spacing: 0 10px !important;
        width: 100% !important;
    }
    #blogTable thead th {
        border: none !important;
        background-color: transparent !important;
        font-weight: 600;
        color: #64748b !important;
        padding-bottom: 12px;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    #blogTable tbody tr {
        background-color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02) !important;
        border-radius: 10px !important;
        transition: all 0.2s ease;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
    }
    #blogTable tbody tr:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.05) !important;
        border-color: rgba(13, 110, 253, 0.15) !important;
    }
    #blogTable tbody td {
        border: none !important;
        padding: 16px 12px !important;
        background-color: #ffffff !important;
    }
    #blogTable tbody td:first-child {
        border-top-left-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
        padding-left: 20px !important;
    }
    #blogTable tbody td:last-child {
        border-top-right-radius: 10px !important;
        border-bottom-right-radius: 10px !important;
        padding-right: 20px !important;
    }

    /* Selected Row Visual Treatment */
    #blogTable tbody tr.selected td {
        background-color: #f8fafc !important;
        color: inherit !important;
    }
    #blogTable tbody tr.selected {
        border-left: 4px solid #3b82f6 !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.08) !important;
    }

    /* Soft Badge Styles */
    .bg-soft-primary {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
    }
    .bg-soft-warning {
        background-color: #fffbeb !important;
        color: #b45309 !important;
    }
    .bg-soft-success {
        background-color: #ecfdf5 !important;
        color: #047857 !important;
    }
    .bg-soft-danger {
        background-color: #fef2f2 !important;
        color: #b91c1c !important;
    }

    /* Action buttons custom styling */
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s ease;
        border-width: 1px;
    }
    .btn-action:hover {
        transform: scale(1.1);
    }

    /* Color lights on category icons */
    .bg-warning-light {
        background-color: rgba(245, 158, 11, 0.12) !important;
    }
    .bg-primary-light {
        background-color: rgba(59, 130, 246, 0.12) !important;
    }

    /* Glow Animation for status dot */
    @keyframes status-glow {
        0% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
        }
        70% {
            box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }
    #blogTable tbody tr td span.badge.bg-soft-success .status-dot {
        animation: status-glow 2s infinite;
    }

    /* DataTables Custom Controls Integration */
    .dt-search {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }
    .dt-search input {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 6px 12px !important;
        font-size: 0.875rem !important;
        outline: none !important;
        transition: all 0.2s;
        background-color: #fff !important;
    }
    .dt-search input:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }
    .dt-length select {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 4px 8px !important;
        font-size: 0.85rem !important;
    }
    .dt-paging-button {
        border-radius: 6px !important;
        border: 1px solid #e2e8f0 !important;
        background: #fff !important;
        padding: 4px 10px !important;
        margin: 0 2px !important;
        font-size: 0.85rem !important;
        transition: all 0.2s !important;
    }
    .dt-paging-button.current, .dt-paging-button:hover {
        background: #3b82f6 !important;
        color: #fff !important;
        border-color: #3b82f6 !important;
    }
</style>
@endsection