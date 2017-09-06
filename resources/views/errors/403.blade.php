@extends('layouts.app')

@section('title', '403')
@section('meta_keywords', '403')
@section('meta_description', '403')

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 403</h2>
        <div class="error-content">
            <h2><i class="fa fa-warning text-yellow"></i> Oops! Forbidden.</h2>
            <div class="middle-box  animated fadeInDown">
                <div class="error-desc">
                    Sorry, but you don't have permission to access this page
                    <a href="{{  route('index') }}">return to dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection
