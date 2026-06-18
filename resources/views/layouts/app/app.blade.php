<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>TechFlow - CMS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.translations = {
            error: "{{ __('messages.error') }}",
            success: "{{ __('messages.success') }}",
            info: "{{ __('messages.info') }}",
            select_item: "{{ __('messages.select_item') }}",
            are_you_sure: "{{ __('messages.are_you_sure') }}",
            yes: "{{ __('messages.yes') }}",
            no: "{{ __('messages.no') }}"
        };
    </script>

	<link href="/template/static/css/app.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/select/3.1.3/css/select.dataTables.min.css" rel="stylesheet">

<style>
	.min-btn{
		min-width:100px;
	}
	.min-btn-table{
		min-width:50px;
	}
	.content{
		padding: ıren ıren 0px;
	}

	.card-border{
		border-bottom:1px solid #cdcdcd !important;
	}
</style>
</head>

<body>
	<div class="wrapper">
		@include('layouts.app.menü')

		<div class="main">
			@include('layouts.app.navbar')

			<main class="content">
				<div class="container-fluid p-0">

                @yield('content')

				</div>
			</main>

			@include('layouts.app.footer')
		</div>
	</div>
	<script src="https://cdn.tiny.cloud/1/dhugr1wp0bq5sw4avg4j3ln1786mzdtc3oxplcph7iz54bm6/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

	@vite(["resources/js/plugins.js"])
    @vite(["resources/js/app.js"])
	<script src="/template/static/js/app.js"></script>
	@yield('js')

</body>

</html>