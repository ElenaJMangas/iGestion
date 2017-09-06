@extends('layouts.app')

@section('title', 'Calendar')
@section('meta_keywords','calendar, events')
@section('meta_description','Calendar')

@section('pagecss')

    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/fullcalendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/fullcalendar/fullcalendar.print.css') }}"
          media="print">

    <!-- Time Picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-timepicker/jquery.timepicker.css') }}">

    <!-- Tags Input -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"/>

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/iCheck/square/blue.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/dist/css/pages/calendar.css') }}">
@endsection

@section('content')
@section('header_title', __('general.calendar'))

{{-- Row 1 --}}
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body no-padding">
                <div id="calendar"></div>
                <div class="modal fade" role="dialog" id="modal">
                    @include('partials.modalcalendar')
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('after_footer')
    <!-- fullcalendar -->
    <script src="{{ asset('assets/adminlte/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    @if(App::getLocale() == 'es')
        <script src="{{ asset('assets/plugins/fullcalendar/lang/es.js') }}"></script>
    @endif

    <!-- Time Picker -->
    <script src="{{ asset('assets/plugins/jquery-timepicker/jquery.timepicker.min.js') }}"></script>

    <!-- datepair -->
    <script src="{{ asset('assets/plugins/datepair/jquery.datepair.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepair/datepair.min.js') }}"></script>

    <!-- iCheck -->
    <script src="{{ asset('assets/adminlte/plugins/iCheck/icheck.min.js') }}"></script>

    <!-- Tags Input -->
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

    <!-- Typeahead -->
    <script src="{{ asset('assets/plugins/typeahead/typeahead.bundle.min.js') }}"></script>

    <!-- Delete method jquery -->
    <script src="{{ asset('assets/dist/js/laravel.js') }}"></script>

    <script src="{{ asset('assets/dist/js/pages/calendar.js') }}"></script>
@endsection
