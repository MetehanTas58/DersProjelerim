@extends('layouts.app.app')

@section('content')
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-primary fw-bold">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="">Blog/Haber {{ $blog == null ? 'Kayıt' : 'Güncelleme' }} İşlemleri
                            {{ $blog == null ? '' : " - " . $blog->title }}
                        </h3>
                    </div>
                    <div class="col-sm-12">
                        <div class="float-end d-flex align-items-center gap-2">
                            <select class="lang-select-header" name="lang_code">
                                <option value="tr" selected>TR</option>
                                <option value="en">EN</option>
                            </select>
                            <span class="badge badge-primary bg-primary" style="font-style:italic;">Blog/Haber {{ $blog == null ? 'Kayıt' : 'Güncelleme' }} Bölümü.</span>
                        </div>
                        <div>
                            <a href="{{ route('blog') }}"
                                class="btn btn-outline-secondary px-4 me-2 rounded-pill shadow-sm">
                                <i class="fas fa-arrow-left me-1"></i> Listeye Dön
                            </a>
                            <button type="button"
                                class="btn btn-primary px-4 rounded-pill shadow-sm btn-save-blog saveBlogBtn">
                                <i class="fas fa-save me-1"></i> Bilgileri Kaydet
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card shadow-lg border-0 rounded-4 mt-3">
                    <div class="card-body p-5">
                        <form id="blogForm" autocomplete="off">
                            <div class="row g-4">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="title" class="form-label fw-semibold text-secondary">Başlık</label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-heading text-muted"></i></span>
                                            <input type="text"
                                                class="form-control title bg-light border-0 placeholder-muted"
                                                id="title" name="title" placeholder="Başlık Yazınız"
                                                value="{{ $blog == null ? '' : $blog->title }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="description" class="form-label fw-semibold text-secondary">Kısa Açıklama</label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-align-left text-muted"></i></span>
                                            <input type="text"
                                                class="form-control description bg-light border-0 placeholder-muted" 
                                                id="description" name="description" placeholder="Kısa Açıklama Yazınız"
                                                value="{{ $blog == null ? '' : $blog->description }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="content" class="form-label fw-semibold text-secondary">Detaylı İçerik</label>
                                        <textarea class="form-control content-editor bg-light border-0 placeholder-muted shadow-sm rounded-3" 
                                            id="blogContent" name="content" rows="6" placeholder="Detaylı İçerik Yazınız">{{ $blog == null ? '' : $blog->content }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="type_id" class="form-label fw-semibold text-secondary">Tip <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-list text-muted"></i></span>
                                            <select class="form-select type_id bg-light border-0 text-muted" id="type_id"
                                                name="type_id">
                                                <option value="1" {{ $blog == null ? 'selected' : ($blog->type_id == 1 ? 'selected' : '') }}>Blog</option>
                                                <option value="2" {{ $blog == null ? '' : ($blog->type_id == 2 ? 'selected' : '') }}>Haber</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="status" class="form-label fw-semibold text-secondary">Durum <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-check-circle text-muted"></i></span>
                                            <select class="form-select status bg-light border-0 text-muted" id="status"
                                                name="status">
                                                <option value="1" {{ $blog == null ? 'selected' : ($blog->status == 1 ? 'selected' : '') }}>Aktif</option>
                                                <option value="0" {{ $blog == null ? '' : ($blog->status == 0 ? 'selected' : '') }}>Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="blog_id" value="{{ $blog == null ? '' : $blog->id }}" class="blog_id" />
                        </form>
                    </div>
                </div>
@section('js')
    <script type="text/javascript">
        var checkInterval = setInterval(function () {
            if (app.loader !== undefined && app.loader !== null) {
                app.loader.setModule("Blog");
                clearInterval(checkInterval);
            }
        }, 500);
    </script>
@endsection

<style>
    .placeholder-muted::placeholder {
        color: #adb5bd !important;
        opacity: 0.8;
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: none;
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
    }

    .input-group {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .input-group:focus-within {
        border-radius: 0.5rem;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
    }

    /* Dil seçici - input-group içinde düzgün görünmesi için */
    .lang-select-wrapper {
        display: flex;
        align-items: center;
        padding: 0;
        margin: 0;
        width: auto;
    }

    /* Dil seçici - başlık alanında badge yanında */
    .lang-select-header {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        background-color: #fff;
        color: #6c757d;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 3px 8px;
        cursor: pointer;
        outline: none;
    }

    .lang-select-header:focus {
        box-shadow: none;
        border-color: #86b7fe;
    }

    .lang-select {
        height: 100%;
        border: none;
        border-right: 1px solid #dee2e6 !important;
        border-radius: 0 !important;
        background-color: #f8f9fa;
        color: #6c757d;
        font-size: 0.875rem;
        padding: 0 0.5rem;
        min-width: 70px;
        width: 70px;
        cursor: pointer;
    }

    .lang-select:focus {
        box-shadow: none !important;
        border: none !important;
        border-right: 1px solid #dee2e6 !important;
        background-color: #f8f9fa !important;
    }
</style>
@endsection
