@extends('layouts.app')

@section('title', __('titles.notifications'))
@section('meta_keywords','notifications')
@section('meta_description','Notifications')

@section('content')
@section('header_title', __('titles.notifications'))

<div class="row">
    <div class="col-md-12">
        @include('partials.timeline')
    </div>
</div>
@endsection
