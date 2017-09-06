@extends('layouts.app')

@section('title', (isset($task->id))  ? __('general.update') : __('task.new'))

@section('meta_keywords','')

@section('meta_description',' ')

@section('pagecss')
    <link rel="stylesheet"
          href="{{ asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

    <!-- Tags Input -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"/>
@endsection

@section('content')
@section('header_title', __('titles.task'))

{{-- Row 1 --}}
<div class="row">
    <div class="col-md-12" id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($task->id)) @lang('general.update') @else @lang('task.new') @endif</h3>
                    </div>
                    <form id="taskdetail" class="form-horizontal" role="form"
                          action="{{ isset($task->id) ? route('task.update', ['id' => $task->id]) : route('task.create')}}"
                          method="POST">
                        {{ csrf_field() }}
                        @include('partials.updatetask')
                        <input type="hidden" name="redirect_url" value="{{ \App\Helpers\Helper::getReferer() }}"/>
                        <input type="hidden" name="project_id" value="{{ $project_id }}"/>
                        <div class="box-footer">
                            <a href="{{\App\Helpers\Helper::getReferer()}}"
                               class="btn btn-default">@lang('general.cancel')</a>
                            <button type="submit" class="btn btn-primary pull-right">@lang('general.save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_footer')
    <script src="{{ asset('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- Tags Input -->
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

    <!-- Typeahead -->
    <script src="{{ asset('assets/plugins/typeahead/typeahead.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/pages/task.js') }}"></script>
@endsection
