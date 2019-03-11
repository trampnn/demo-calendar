<header>

	<nav class="navbar navbar-toggleable-md navbar-light bg-faded">

		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

		    <span class="navbar-toggler-icon"></span>

		</button>

	  	<a class="navbar-brand" href="#">

		    <img src="{{ Voyager::setting('logo') }}" width="30" height="30" class="d-inline-block align-top" alt="">

		    NKS demopage

	  	</a>

	  	<div class="collapse navbar-collapse" id="navbarSupportedContent">

		    <ul class="navbar-nav ml-lg-auto">

		      	@if(Auth::check())

		      		<li class="nav-item dropdown">

			        	<a class="nav-link dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="/"><img src="{{Auth::user()->avatar}}" alt="" class="img-fluid rounded" style="height: 30px;"></a>

			        	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">

			        		<h6 class="dropdown-header" style="color: #00CADB">{{Auth::user()->name}}</h6>

						    <a class="dropdown-item" href="#">{{ trans('web.Profile') }}</a>

						    <div class="dropdown-divider"></div>

						    <a class="dropdown-item" href="/logout">{{ trans('web.Logout') }}</a>

						</div>

			      	</li>

		      	@else

		      		<li class="nav-item">

			        	<a class="nav-link" href="{{route('Login')}}">{{ trans('web.Login') }}</a>

			      	</li>

			      	<li class="nav-item">

			        	<a class="nav-link" href="{{route('Register')}}">{{ trans('web.Register') }}</a>

			      	</li>

		      	@endif

		      	<li class="nav-item dropdown">

		      		<a class="nav-link dropdown-toggle" id="langselect" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="/"><i class="fa fa-language" style="margin-right: 5px;"></i><span id="lang-display" style="text-transform: uppercase;">{{ $lang =session('locate') ?: 'en' }}</span></a>

		      		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="langselect" style="min-width: auto;">

					    <a class="dropdown-item" href="javascript:;" data-lang="vi" onclick="changelang(this)">{{trans('web.viLang')}}</a>

					    <a class="dropdown-item" href="javascript:;" data-lang="en" onclick="changelang(this)">{{trans('web.enLang')}}</a>

					</div>

		      	</li>

		    </ul>

		</div>

	</nav>

</header>