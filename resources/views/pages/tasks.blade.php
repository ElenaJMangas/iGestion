@extends('layouts.app')

@section('title', 'Tasks')
@section('meta_keywords','tasks, pending, doing, finish')
@section('meta_description','Tasks')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('assets/dist/css/pages/tasks.css') }}">
@endsection

@section('content')
@section('header_title', __('titles.tasks'))

<div class="clearfix">
    <div class="pull-right top-page-ui">
        <a href="{{route('task.form')}}" class="btn btn-primary pull-right">
            <i class="fa fa-plus-circle fa-lg"></i> @lang('task.new')
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="project-list">
                    <table class="table table-hover">
                        <tbody>
                        @foreach($tasks as $task)
                            @include('partials.tasks')
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
