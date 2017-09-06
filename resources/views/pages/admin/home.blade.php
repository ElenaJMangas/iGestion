@extends('layouts.app')

@section('title', 'Dashboard')
@section('meta_keywords','control, panel, dashboard')
@section('meta_description','Control panel')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/daterangepicker/daterangepicker.css') }}">
@endsection

@section('content')
@section('header_title', __('titles.adminDashboard'))
@section('header_description', __('titles.dashStatistics'))

{{-- Row 1 --}}
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">@choice('general.comment', 2)</span>
                <span class="info-box-number">{{ $totalComments }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">@choice('calendar.event', 2)</span>
                <span class="info-box-number">{{ $totalEvents }}</span>
            </div>
        </div>
    </div>

    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@choice('project.member', 2)</span>
                <span class="info-box-number">{{ $totalMembers }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Row 2 --}}
<div class="row">
    <section class="col-lg-7 connectedSortable">
        @include('partials.events')
        @include('partials.projecttask')
    </section>
    <section class="col-lg-5 connectedSortable">
        @include('partials.calendar')
        @include('partials.members')
    </section>
</div>
@endsection

@section('after_footer')
    <script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>
@endsection
