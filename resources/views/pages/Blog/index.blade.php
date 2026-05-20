@extends('layouts.app.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h3 class="">Blog/Haber Listesi</h3>
        </div>
        <div class="col-sm-12">
<spam class="badge badge-primary bg-primary float-end" style="font-style:italic;">Blog/Haber listeleme bölümü.</spam>

</div>
    </hr>
    <hr>
    </hr>
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