@extends('layouts.app')

@section('title', 'Projects')
@section('meta_keywords','projects')
@section('meta_description','Projects')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('assets/dist/css/pages/projects.css') }}">
@endsection

@section('content')
@section('header_title', __('titles.projects'))
@section('header_description', __('titles.projectsSub'))

{{-- Row 1 --}}
@if(\Auth::user()->isAdmin())
    <div class="clearfix">
        <div class="pull-right top-page-ui">
            <a href="{{route('project.update')}}" class="btn btn-primary pull-right">
                <i class="fa fa-plus-circle fa-lg"></i> @lang('project.new')
            </a>
        </div>
    </div>
@endif

<div class="row">
    @foreach ($projects as $project)
        @include('partials.project')
    @endforeach
</div>
@endsection
