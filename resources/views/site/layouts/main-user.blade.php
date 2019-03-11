@extends('site.layouts.main')
@section('title')
	@yield('title')
@stop
@section('main-style')

	<link rel="stylesheet" href="site/middleware/assets/css/icons.css" />
	<link rel="stylesheet" href="site/middleware/assets/css/style.css" />
	<link rel="stylesheet" href="site/middleware/assets/css/metismenu.min.css" />
	<link rel="stylesheet" href="site/middleware/assets/css/style_cl.css" />
	<link rel="stylesheet" href="site/middleware/assets/css/style-custom.css">
	<link href="site/middleware/plugins/jquery-toastr/jquery.toast.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="site/middleware/assets/css/mystyle-admin.css">

	@yield('style')

	
@stop

@section('main-content')

@if(Route::is('login', 'register', 'recoverpw', 'builder'))
		@yield('content')
@else
<div id="wrapper">
	@include('site.layouts.sidebar-user')

	@include('site.layouts.header-user')

	<div class="content-page">
		@yield('content')

		@include('site.layouts.footer-user')
	</div>

</div>
@endif

@stop
@section('main-script')

	<script src="vendor/popper-1.14.3/popper-1.14.3.min.js"></script>
	<script src="site/middleware/assets/js/metisMenu.min.js"></script>
  	<script src="site/middleware/assets/js/waves.js"></script>
  	<script src="site/middleware/plugins/jquery-toastr/jquery.toast.min.js" type="text/javascript"></script>
  	<script src="site/middleware/assets/js/jquery.slimscroll.js" type="text/javascript"></script>
  	<script src="site/middleware/plugins/select2-4.0.6-rc.1/dist/js/select2.full.min.js" type="text/javascript"></script>
  	<script src="site/middleware/plugins/raty-fa/jquery.raty-fa.js" type="text/javascript"></script>
  	<script src="site/middleware/plugins/switchery/switchery.min.js" type="text/javascript"></script>
  	<script src="site/middleware/plugins/custombox/js/custombox.min.js"></script>
  	<script src="site/middleware/plugins/custombox/js/legacy.min.js"></script>
  	<script src="site/middleware/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>
	<script src="site/middleware/assets/js/jquery.app.js" type="text/javascript"></script>
	<script src="site/middleware/assets/js/jquery.core.js" type="text/javascript"></script>

	@yield('script')
@stop
