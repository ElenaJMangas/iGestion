@extends('layouts.app')

@section('title', (isset($project->id)) ? $project->title : __('project.new'))
@section('meta_keywords','')
@section('meta_description',' ')

@section('pagecss')
    <!-- Tags Input -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"/>
@endsection

@section('content')
@section('header_title', (isset($project->id)) ? $project->title : '')

{{-- Row 1 --}}
<div class="row">
    <div class="col-md-12" id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($project->id)) {{ __('project.edit') }} @else {{__('project.new')}} @endif</h3>
                    </div>
                    <form id="projectdetail" class="form-horizontal" role="form"
                          action="{{route('project.save', isset($project->id) ? $project->id : NULL)}}" method="POST">
                        {{ csrf_field() }}
                        @if(isset($project->id))
                            <input name="_method" type="hidden" value="PUT">
                        @endif
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-sm-2 control-label">@lang('project.title')</label>

                                <div class="col-sm-10">
                                    <input type="text" name='title'
                                           value="{{ isset($project->title) ?  $project->title : old('title')  }}"
                                           class="form-control" id="title" placeholder="@lang('project.title')" required
                                           pattern="([a-zA-ZÁÉÍÓÚñáéíóú0-9]+[\s]*){3,}"
                                           title="@lang('general.typeUsername',['num'=>3])">
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description"
                                       class="col-sm-2 control-label">@lang('project.description')</label>

                                <div class="col-sm-10">
                                        <textarea required name="description" class="form-control" rows="5"
                                                  placeholder="@lang('project.description')">{{ isset($project->description) ?  $project->description : old('description')  }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('priority') ? ' has-error' : '' }}">
                                <label for="priority" class="col-sm-2 control-label">@lang('general.priority')</label>
                                <div class="col-sm-10">
                                    {{ Form::select('priority', $priorities, isset($project->priority_id) ? $project->priority_id : old('priority'), ['class' => 'form-control','required'])}}
                                </div>
                            </div>
                            @if(\Auth::user()->isAdmin())
                                @if(isset($project->id))
                                    <div class="form-group {{ $errors->has('priority') ? ' has-error' : '' }}">
                                        <label for="status"
                                               class="col-sm-2 control-label">@lang('general.status')</label>
                                        <div class="col-sm-10">
                                            {{ Form::select('status', [__('project.inProgress'),__('project.finished')], isset($project->status_id) ? $project->status_id : old('status'), ['class' => 'form-control','required'])}}
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="to">@lang('project.to')</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="to" id="to"
                                               data-role="tagsinput"/>
                                        @if(isset($project->id))
                                            @foreach($project->members as $project_user)
                                                @if($project_user->user_id != Auth::user()->id)
                                                    <input class="recipients" type="hidden"
                                                           value="{{$project_user->user_id.",".$project_user->user->getFullName()}}"/>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="box-footer">
                            <a href="{{ \App\Helpers\Helper::getReferer() }}" class="btn btn-default">@lang('general.cancel')</a>
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
    <!-- Tags Input -->
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

    <!-- Typeahead -->
    <script src="{{ asset('assets/plugins/typeahead/typeahead.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/pages/projects.js') }}"></script>
@endsection
