@extends('layouts.app')

@section('title', '404')
@section('meta_keywords', '404')
@section('meta_description', '404')

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="error-content">
            <h2><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h2>
            <div class="middle-box  animated fadeInDown">
                <div class="error-desc">
                    Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.
                    <a href="{{  route('index') }}">return to dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection
