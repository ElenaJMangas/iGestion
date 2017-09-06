@extends('layouts.app')

@section('title', '')
@section('meta_keywords','')
@section('meta_description',' ')

@section('pagecss')
    <link rel="stylesheet"
          href="{{ asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

    <!-- Tags Input -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"/>
@endsection

@section('content')
@section('header_title', 'Project Task')

{{-- Row 1 --}}
<div class="row">
    <div class="col-md-12" id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('general.update')</h3>
                    </div>
                    <form id="taskdetail" class="form-horizontal" role="form"
                          action="{{route('project.task.new',$project_id)}}" method="POST">
                        {{ csrf_field() }}
                        @include('partials.updatetask')
                        <input type="hidden" id="project_id" value="{{$project_id}}">
                        <div class="box-footer">
                            <a href="{{route('project',$project_id)}}"
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

    <script src="{{ asset('assets/dist/js/pages/projecttask.js') }}"></script>
@endsection
