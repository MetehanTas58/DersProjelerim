@extends('layouts.app.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800">Kullanıcı Listesi</h1>
        <p class="text-muted mb-0 small">Sistemdeki tüm kayıtlı kullanıcıları ve durumlarını bu alandan yönetebilirsiniz.</p>
    </div>
    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2" style="font-style: italic; font-weight: 500;">
        <i class="bi bi-people-fill me-1"></i> Kullanıcılar Yönetim Bölümü
    </span>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary min-btn topEditUserBtn" disabled>
                <i class="bi bi-pencil-square me-1"></i> Düzenle
            </button>
            <button type="button" class="btn btn-outline-danger min-btn topDelUserBtn" disabled>
                <i class="bi bi-trash-fill me-1"></i> Sil
            </button>
        </div>
        <a href="{{route('users/new')}}" class="btn btn-success min-btn">
            <i class="bi bi-plus-circle me-1"></i> Yeni Ekle
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle w-100" id="usersTable">
                <thead>
                    <tr>
                        <th>Adı Soyadı</th>
                        <th>E-Mail Adresi</th>
                        <th>Telefon Numarası</th>
                        <th>Durumu</th>
                        <th width="150px">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

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