<!-- ========== Top Bar Start ========== -->
<div class="topbar">
	<nav class="navbar-custom d-flex flex-row-reverse justify-content-between align-items-center">
		<ul class="list-unstyled topbar-right-menu d-flex align-items-center mb-0">
			<li class="hide-phone app-search">
				<form>
					<input type="text" placeholder="Search..." class="form-control">
					<button type="submit"><i class="fas fa-search"></i></button>
				</form>
			</li>

			<li class="dropdown notification-list">
				<a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button"
				   aria-haspopup="false" aria-expanded="false">
					<i class="fi-bell noti-icon"></i>
					<span class="badge badge-danger badge-pill noti-icon-badge">4</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg">
					<!-- item-->
					<div class="dropdown-item noti-title">
						<h5 class="m-0"><span class="float-right"><a href="" class="text-dark"><small>Clear All</small></a> </span>Notification</h5>
					</div>

					<div class="slimscroll" style="max-height: 230px;">
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-success"><i class="mdi mdi-comment-account-outline"></i></div>
							<p class="notify-details">Caleb Flakelar commented on Admin<small class="text-muted">1 min ago</small></p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-info"><i class="mdi mdi-account-plus"></i></div>
							<p class="notify-details">New user registered.<small class="text-muted">5 hours ago</small></p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-danger"><i class="mdi mdi-heart"></i></div>
							<p class="notify-details">Carlos Crouch liked <b>Admin</b><small class="text-muted">3 days ago</small></p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-warning"><i class="mdi mdi-comment-account-outline"></i></div>
							<p class="notify-details">Caleb Flakelar commented on Admin<small class="text-muted">4 days ago</small></p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-purple"><i class="mdi mdi-account-plus"></i></div>
							<p class="notify-details">New user registered.<small class="text-muted">7 days ago</small></p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-custom"><i class="mdi mdi-heart"></i></div>
							<p class="notify-details">Carlos Crouch liked <b>Admin</b><small class="text-muted">13 days ago</small></p>
						</a>
					</div>

					<!-- All-->
					<a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
						View all <i class="fi-arrow-right"></i>
					</a>
				</div>
			</li>

			<li class="dropdown notification-list">
				<a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button"
				   aria-haspopup="false" aria-expanded="false">
					<i class="fi-speech-bubble noti-icon"></i>
					<span class="badge badge-custom badge-pill noti-icon-badge">6</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg">
					<!-- item-->
					<div class="dropdown-item noti-title">
						<h5 class="m-0"><span class="float-right"><a href="" class="text-dark"><small>Clear All</small></a> </span>Chat</h5>
					</div>

					<div class="slimscroll" style="max-height: 230px;">
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon"><img src="site/middleware/assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle" alt="" /> </div>
							<p class="notify-details">Cristina Pride</p>
							<p class="text-muted font-13 mb-0 user-msg">Hi, How are you? What about our next meeting</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon"><img src="site/middleware/assets/images/users/avatar-3.jpg" class="img-fluid rounded-circle" alt="" /> </div>
							<p class="notify-details">Sam Garret</p>
							<p class="text-muted font-13 mb-0 user-msg">Yeah everything is fine</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon"><img src="site/middleware/assets/images/users/avatar-4.jpg" class="img-fluid rounded-circle" alt="" /> </div>
							<p class="notify-details">Karen Robinson</p>
							<p class="text-muted font-13 mb-0 user-msg">Wow that's great</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon"><img src="site/middleware/assets/images/users/avatar-5.jpg" class="img-fluid rounded-circle" alt="" /> </div>
							<p class="notify-details">Sherry Marshall</p>
							<p class="text-muted font-13 mb-0 user-msg">Hi, How are you? What about our next meeting</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon"><img src="site/middleware/assets/images/users/avatar-6.jpg" class="img-fluid rounded-circle" alt="" /> </div>
							<p class="notify-details">Shawn Millard</p>
							<p class="text-muted font-13 mb-0 user-msg">Yeah everything is fine</p>
						</a>
					</div>

					<!-- All-->
					<a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
						View all <i class="fi-arrow-right"></i>
					</a>
				</div>
			</li>
			@if(Auth::check())
			<li class="dropdown notification-list topbar-account">
				<a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
				   aria-haspopup="false" aria-expanded="false">
					<img src="{{Auth::user()->avatar}}" alt="user" class="rounded-circle" id="avatar"> <span class="ml-1" id="username">{{Auth::user()->name}}<i class="mdi mdi-chevron-down"></i></span>
				</a>
				<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
					<!-- item-->
					<div class="dropdown-item noti-title">
						<h6 class="text-overflow m-0">Welcome !</h6>
					</div>

					<!-- item-->
					<a href="/account/{{Auth::user()->name}}/profile" class="dropdown-item notify-item" id="lnkinfo">
						<i class="fi-head"></i> <span>My Account</span>
					</a>

					<!-- item-->
					<a href="javascript:void(0);" class="dropdown-item notify-item">
						<i class="fi-cog"></i> <span>Settings</span>
					</a>

					<!-- item-->
					<a href="javascript:void(0);" class="dropdown-item notify-item">
						<i class="fi-help"></i> <span>Support</span>
					</a>

					<!-- item-->
					<a href="javascript:void(0);" class="dropdown-item notify-item">
						<i class="fi-lock"></i> <span>Lock Screen</span>
					</a>

					<!-- item-->
					<a href="/account/logout" class="dropdown-item notify-item" id="btnLogout">
						<i class="fi-power"></i> <span>Logout</span>
					</a>
				</div>
			</li>
			@endif
		</ul>

		<ul class="list-unstyled menu-left d-flex align-items-center mb-0">
			<li class="mr-3">
				<button class="button-menu-mobile open-left">
					<i class="dripicons-menu"></i>
				</button>
			</li>
			<li class="title-adcp" style="font-size: 18px; font-weight: bold; color: #7c8e9a">Admin Control Panel</li>
			<li class="title">
				<span style="margin-right: 16px; font-size: 18px; font-weight: bold; color: #7c8e9a">{{$title}}</span>

				<ul class="social-links list-unstyled mb-0">
					<li class="mr-3">
						<a title="" data-placement="bottom" data-toggle="tooltip" class="tooltips" href="" data-original-title="Save all changes"><i class="mdi mdi-content-save"></i></a>
					</li>
					<li class="mr-3">
						<a title="" data-placement="bottom" data-toggle="tooltip" class="tooltips" href="" data-original-title="Clear all change"><i class="mdi mdi-eraser"></i></a>
					</li>
					<li>
						<a title="" data-placement="bottom" data-toggle="tooltip" class="tooltips" href="" data-original-title="Delete"><i class="mdi mdi-delete"></i></a>
					</li>
				</ul>
			</li>
		</ul>
	</nav>
</div>
<!-- ========== Top Bar End ========== -->