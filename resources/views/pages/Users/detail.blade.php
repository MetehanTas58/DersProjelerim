@extends('layouts.app.app')

@section('content')
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-primary fw-bold">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="">Kullanıcı {{ $user == null ? 'Kayıt' : 'Güncelleme' }} İşlemleri
                            {{ ($user == null ? "" : " - " . $user->name)}}
                        </h3>
                    </div>
                    <div class="col-sm-12">
                        <span class="badge badge-primary bg-primary float-end" style="font-style:italic;">Kullanıcı
                            {{ $user == null ? "Kayıt" : "Güncelleme" }} Bölümü.</span>
                        <div style="text-align: right;">
                        </div>
                        </hr>
                        <div>
                            <a href="{{ route('users') }}"
                                class="btn btn-outline-secondary px-4 me-2 rounded-pill shadow-sm">
                                <i class="fas fa-arrow-left me-1"></i> Listeye Dön
                            </a>
                            <button type="button"
                                class="btn btn-primary px-4 rounded-pill shadow-sm btn-save-user saveUserBtn">
                                <i class="fas fa-save me-1"></i> Bilgileri Kaydet
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <form id="usersForm" autocomplete="off">
                            <div class="row g-4">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="name_surname" class="form-label fw-semibold text-secondary">Adı
                                            Soyadı</label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-user text-muted"></i></span>
                                            <input type="text"
                                                class="form-control name_surname bg-light border-0 placeholder-muted"
                                                id="name_surname" name="name_surname" placeholder="Adı Soyadı Yazınız"
                                                value="{{ $user == null ? null : $user->name }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="email" class="form-label fw-semibold text-secondary">E-Mail
                                            Adresi</label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-envelope text-muted"></i></span>
                                            <input type="email"
                                                class="form-control email bg-light border-0 placeholder-muted" id="email"
                                                name="email" placeholder="E-Mail Adresinizi Yazınız"
                                                autocomplete="new-password"
                                                value="{{ $user == null ? null : $user->email }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="password" class="form-label fw-semibold text-secondary">Şifre <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-lock text-muted"></i></span>
                                            <input type="password"
                                                class="form-control password bg-light border-0 placeholder-muted"
                                                id="password" name="password" placeholder="Şifrenizi Yazınız"
                                                autocomplete="new-password">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="password_repeat" class="form-label fw-semibold text-secondary">Şifre
                                            Tekrarı <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-lock text-muted"></i></span>
                                            <input type="password"
                                                class="form-control password_rep bg-light border-0 placeholder-muted"
                                                id="password_repeat" name="password_repeat"
                                                placeholder="Şifrenizi Tekrar Yazınız">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="phone" class="form-label fw-semibold text-secondary">Telefon
                                            Numarası</label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-phone text-muted"></i></span>
                                            <input type="number"
                                                class="form-control phonebg-light border-0 placeholder-muted" id="phone"
                                                name="phone" placeholder="Telefon Numaranızı Yazınız"
                                                value="{{ $user == null ? null : $user->phone }}">
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
                                                <option value="1" {{$user == null ? 'selected' : ($user->status == 1 ? 'selected' : '')}}>Aktif</option>
                                                <option value="0" {{$user == null ? '' : ($user->status == 0 ? 'selected' : '')}}>
                                                    Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $user == null ? null : $user->id }}" class="user_id" />
                        </form>
                    </div>
                </div>
                @section('js')
                    <script type="text/javascript">

                        var checkInterval = setInterval(function () {
                            if (app.loader !== undefined && app.loader !== null) {
                                app.loader.setModule("Users");
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
                </style>
@endsection