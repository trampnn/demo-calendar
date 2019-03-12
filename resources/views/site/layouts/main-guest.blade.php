@extends('site.layouts.main')

@section('title')
	@yield('title')
@endsection

@section('main-style')
  <!-- ========== CSS Framwork ========== -->
  <link rel="stylesheet" href="vendor/bootstrap-4.2.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- ========== CSS Page ========== -->
  @yield('page-css')

  <!-- ========== CSS Site ========== -->
  <link rel="stylesheet/less" type="text/css" href="site/scss/site.less" />

	@yield('style')
@endsection

@section('main-content')
	@include('site.layouts.header-guest')
	@yield('content')
	@include('site.layouts.footer-guest')
@endsection

@section('modal')
	@yield('page-modal')
@endsection

@section('main-script')
  <!-- ========== JS Framwork ========== -->
  <script src="vendor/bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>

  <!-- ========== JS Page ========== -->
  @yield('page-js')
  
  <!-- ========== JS Site ========== -->
  <script src="site/js/site.js"></script>

	@yield('script')
@endsection