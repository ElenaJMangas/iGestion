@extends('layouts.app')

@section('title', '500')
@section('meta_keywords', '500')
@section('meta_description', '500')

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 500</h2>
        <div class="error-content">
            <h2><i class="fa fa-warning text-yellow"></i> Oops! Something went wrong!</h2>
            <div class="middle-box  animated fadeInDown">
                <div class="error-desc">
                    <h3>You have experienced a technical error. We apologize.</h3>

                    We are working hard to correct this issue. Please wait a few moments and try your search again.
                    In the meantime, check out whats new on SmartAdmin:
                    <a href="{{  route('index') }}">return to dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection
