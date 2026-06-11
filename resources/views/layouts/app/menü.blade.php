<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
          <span class="align-middle">TechFlow CMS</span>
        </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						{{ __('messages.apps') }}
					</li>

					<li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{route('dashboard')}}">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">{{ __('messages.dashboard') }}</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="pages-profile.html">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">{{ __('messages.page_operations') }}</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{route('blog')}}">
              <i class="align-middle" data-feather="book"></i> <span class="align-middle">{{ __('messages.blog_news') }}</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="pages-sign-up.html">
              <i class="align-middle" data-feather="image"></i> <span class="align-middle">{{ __('messages.galleries') }}</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="pages-blank.html">
              <i class="align-middle" data-feather="alert-circle"></i> <span class="align-middle">{{ __('messages.popup_management') }}</span>
            </a>
					</li>
                    		<li class="sidebar-item">
						<a class="sidebar-link" href="pages-blank.html">
              <i class="align-middle" data-feather="settings"></i> <span class="align-middle">{{ __('messages.settings') }}</span>
            </a>
					</li>

                    		<li class="sidebar-item {{ request()->routeIs('users') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{route('users')}}">
              <i class="align-middle" data-feather="users"></i> <span class="align-middle">{{ __('messages.user_management') }}</span>
            </a>
					</li>


			</div>
		</nav>