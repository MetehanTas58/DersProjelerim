<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
          <span class="align-middle">TechFlow CMS</span>
        </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Uygulamalar
					</li>

					<li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{route('dashboard')}}">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="pages-profile.html">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Sayfa İşlemleri</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{route('blog')}}">
              <i class="align-middle" data-feather="book"></i> <span class="align-middle">Blog & Haber</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="pages-sign-up.html">
              <i class="align-middle" data-feather="image"></i> <span class="align-middle">Galeriler</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="pages-blank.html">
              <i class="align-middle" data-feather="alert-circle"></i> <span class="align-middle">Popup Yönetimi</span>
            </a>
					</li>
                    		<li class="sidebar-item">
						<a class="sidebar-link" href="pages-blank.html">
              <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Ayarlar</span>
            </a>
					</li>

                    		<li class="sidebar-item {{ request()->routeIs('users') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{route('users')}}">
              <i class="align-middle" data-feather="users"></i> <span class="align-middle">Kullanıcı Yönetimi</span>
            </a>
					</li>


			</div>
		</nav>