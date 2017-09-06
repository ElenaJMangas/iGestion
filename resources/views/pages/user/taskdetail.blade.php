@extends('layouts.app')

@section('title', $task->title)
@section('meta_keywords','')
@section('meta_description',' ')

@section('content')
@section('header_title', __('titles.task'))

{{-- Row 1 --}}
<div class="row">
    <div class="col-md-12" id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@choice('general.detail',2)</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">@lang('task.title')</label>
                            <label class="col-sm-10 font-normal">{{$task->title}}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">@lang('task.description')</label>
                            <label class="col-sm-10 font-normal">{{$task->description}}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">@lang('general.priority')</label>
                            <label class="col-sm-10 font-normal">{{ __('general.priorities.'.$task->priority->priority) }}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">@lang('general.status')</label>
                            <label class="col-sm-10 font-normal">{{ __('task.'.$task->tasks_status->status) }}</label>
                        </div>
                        @if( isset($task->target_end_date))
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="when">@lang('task.targetEndDate')</label>
                                <label class="col-sm-10 font-normal">{{ \App\Helpers\Helper::formatDate($task->target_end_date)}}</label>
                            </div>
                        @endif
                    </div>
                    <div class="box-footer">
                        <a href="{{ \App\Helpers\Helper::getReferer() }}"
                           class="btn btn-default">@lang('general.back')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
