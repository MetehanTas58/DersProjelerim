@extends('layouts.auth.auth')

@section('auth_content')
<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Hoşgeldiniz</h1>
							<p class="lead">
								Giriş yapmak için lütfe bilgilerinizi giriniz
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg email" type="email" name="email" placeholder="Email adresinizi giriniz" />
										</div>
										<div class="mb-3">
											<label class="form-label">Şifre</label>
											<input class="form-control form-control-lg password" type="password" name="password" placeholder="Şifrenizi giriniz" />
										</div>
										<div>
											<div class="form-check align-items-center">
												<input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
												<label class="form-check-label text-small" for="customControlInline">Beni Hatırla</label>
											</div>
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="button" class="btn btn-lg btn-primary loginBtn">Giriş yap</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							Henüz hesabınız yok mut? <a href="pages-sign-up.html">Kayıt ol</a>
						</div>
					</div>
				</div>
			</div>
		</div>

<script type="text/javascript">

	
var checkInterval = setInterval(function () {
    if (app.loader !== undefined && app.loader !== null) {
        app.loader.setModule("Login");
        clearInterval(checkInterval);
    }
}, 500);


</script>

@endsection