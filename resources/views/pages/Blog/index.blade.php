@extends('layouts.app.app')

@section('content')
<div class="row">
    <div class="col-sm-12 d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Blog/Haber Listesi</h3>
        <span class="badge bg-primary float-end" style="padding: 8px 12px; font-style: italic;">
            Blog/Haber ile blog ve haber kayıtlarınızı listeleyebilirsiniz.
        </span>
    </div>

    <div class="col-sm-12">
        <div class="card shadow-sm border-0">
            <div class="card-header card-border d-flex justify-content-between align-items-center bg-white py-3">
                <div>
                    <a href="{{ route('blog.new') }}">
                        <button type="button" class="btn btn-success min-btn me-2">Yeni Ekle</button>
                    </a>
                    <button type="button" class="btn btn-primary min-btn editBlogBtn me-2">Düzenle</button>
                    <button type="button" class="btn btn-danger min-btn delBlogBtn">Sil</button>
                </div>
                
                <div class="d-flex align-items-center">
                    <label for="filterStatus" class=" me-2 mb-0 fw-semibold text-secondary" style="white-space: nowrap;">Durum</label>
                    <select id="filterStatus" class="form-select list-cmb status-cmb bg-light border-1" style="width: 200px;">
                        <option value="1"selected>Aktif</option>
                        <option value="0">Pasif</option>
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <label for="filterStatus" class="me-2 mb-0 fw-semibold text-secondary" style="white-space: nowrap;">Tip</label>
                    <select id="filterStatus" class="form-select list-cmb type-cmb bg-light border-1" style="width: 200px;">
                        <option value="0"selected>Tümü</option>
                             <option value="1">Haber</option>
                        <option value="2">Blok</option>
                    </select>
                </div>
                
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered w-100" id="blogTable">
                    <thead>
                        <tr>
                            <th>Başlık</th>
                            <th>Açıklama</th>
                            <th>Tip</th>
                            <th>Durumu</th>
                            <th width="250px">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
@endsection