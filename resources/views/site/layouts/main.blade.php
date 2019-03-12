<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="api-token" content="{{ Session::get('nKs_UserId') }}">

	<title>@yield('title')</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
	<meta content="NKS" name="author" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<base href="{{asset('')}}">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{'storage/'.Voyager::setting('favicon_logo')}}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{'storage/'.Voyager::setting('favicon_logo')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{'storage/'.Voyager::setting('favicon_logo')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{'storage/'.Voyager::setting('favicon_logo')}}">

  @yield('main-style')

  <!-- jQuery -->
  <script src="vendor/jquery-3.3.1/jquery-3.3.1.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js" ></script>
</head>
<body>
  @yield('main-content')

  @yield('modal')

  @yield('dataTables')

  @yield('main-script')
</body>
</html>