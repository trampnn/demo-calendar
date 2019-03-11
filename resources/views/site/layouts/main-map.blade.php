@extends('site.layouts.main')

@section('title')
	@yield('title')
@endsection

@section('main-style')
	@yield('style')
@endsection

@section('main-content')
	@include('site.layouts.header-map')
  
  @yield('content')

  <span id="footerShow">
    <span class="txtDefault">Terms, Privacy, Currency & More</span>
    <span class="txtActive">Close</span>
  </span>

	@include('site.layouts.footer-guest')
@endsection

@section('modal')
	@yield('modal')
@endsection

@section('main-script')
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqk6yLpY4YgJNxMOAIk4Jc-41uO6Sa6pQ"></script>
  <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
  <script src="vendor/gmaps/gmaps.min.js"></script>
  <script src="site/js/smaps.js"></script>

	@yield('page-script')
@endsection