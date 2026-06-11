<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

			<div>
             <div style="float: right;">
            	<select class="form-select form-select-sm" style="cursor: pointer;" onchange="window.location.href = this.value;">
					<option value="{{ url('/lang/tr') }}" {{ app()->getLocale() == 'tr' ? 'selected' : '' }}>Türkçe</option>
					<option value="{{ url('/lang/en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                </select>
               </div>
            </div>
				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">

						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="/template/static/img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark">Metehan</span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> {{ __('messages.profile') }}</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i>{{ __('messages.dashboard') }}</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i>{{ __('messages.settings') }}</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">{{ __('messages.logout') }}</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>