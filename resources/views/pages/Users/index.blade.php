@extends('layouts.app.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h3 class="">Kullanıcı Listesi</h3>
        </div>
        <div class="col-sm-12">
<spam class="badge badge-primary bg-primary float-end" style="font-style:italic;">Kullanıcılar Yönetim Bölümü.</spam>

</div>
    </hr>
    <hr>
    </hr>
    <div class="card">
        <div class="card-header card-border">
            <a href="{{route('users/new')}}"> <button type="button" class="btn btn-success min-btn"><i class="bi bi-plus-circle"></i>Yeni Ekle</button></a>
            <button type="button" class="btn btn-primary min-btn editUserBtn">Düzenle</button>
            <button type="button" class="btn btn-danger  min-btn delUserBtn">Sil</button>


        </div>
        <div class="card/body">
            <table class="table table-striped table-bordered" id="usersTable">
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