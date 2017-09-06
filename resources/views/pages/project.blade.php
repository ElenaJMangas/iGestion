@extends('layouts.app')

@section('title', 'Project')
@section('meta_keywords','project')
@section('meta_description','Project')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('assets/dist/css/pages/project.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/pages/tasks.css') }}">
@endsection

@section('content')
@section('header_title', __('titles.projectDetail'))

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper-content">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-b-md">
                                <a href="{{route('project.update',['id'=>$project->id])}}"
                                   class="btn btn-primary pull-right">@lang('project.edit')</a>
                                <h3 class="box-title">{{$project->title}}</h3>
                            </div>
                            <dl class="dl-horizontal">
                                <dt>@lang('general.status'):</dt>
                                <dd>
                                    <span class="label {{$project->getStatusColour()}}">{{__('project.'.$project->getStatus())}}</span>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <dl class="dl-horizontal">
                                <dt>@lang('general.priority')</dt>
                                <dd> {{__('general.priorities.'.$project->priority->priority)}}</dd>
                                <dt>@lang('project.createdBy')</dt>
                                <dd>{{$project->user->getFullName()}}</dd>
                                <dt>@choice('general.comment',2)</dt>
                                <dd>{{$project->comments->count()}}</dd>
                            </dl>
                        </div>
                        <div class="col-lg-7" id="cluster_info">
                            <dl class="dl-horizontal">
                                <dt>@lang('project.lastUpdate'):</dt>
                                <dd>{{\App\Helpers\Helper::formatDate($project->updated_at)}}</dd>
                                <dt>@lang('project.created'):</dt>
                                <dd>{{\App\Helpers\Helper::formatDate($project->created_at)}}</dd>
                                <dt>@choice('project.member',2):</dt>
                                <dd class="project-people">
                                    @foreach($project->members as $member)
                                        <a href="{{ route('profile',$member->user->id)}}">
                                            <img alt="member" class="img-circle"
                                                 src="{{\App\Helpers\Helper::getAvatarUser($member->user->avatar)}}">
                                        </a>
                                    @endforeach
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <dl class="dl-horizontal">
                                <dt>@lang('project.completed'):</dt>
                                <dd>
                                    <div class="progress progres-bar active m-b-sm .sm">
                                        <div style="width: {{$percentage[$project->id]}}%" class="progress-bar"></div>
                                    </div>
                                    <small>@lang('project.completedIn') <strong>{{$percentage[$project->id]}}%</strong>
                                    </small>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <dl class="dl-horizontal">
                                <dt>@lang('project.descriptionLG'):</dt>
                                <dd>
                                    {{$project->description}}
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row m-t-sm">
                        <div class="col-lg-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">@lang('project.activity')</a>
                                    </li>
                                    <li class=""><a href="#timeline" data-toggle="tab"
                                                    aria-expanded="false">@lang('project.timeLine')</a></li>
                                    <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Tasks</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="activity">
                                        {{Form::open(['route' => ['comment', $project->id], 'method' => 'post','class'=>'well'])}}
                                        <textarea name="comment" rows="1" class="form-control"
                                                  placeholder="@lang('project.box')"></textarea>

                                            <button type="submit" class="btn btn-sm btn-primary pull-right">
                                                @lang('project.send')
                                            </button>

                                        {{ Form::close() }}
                                        <div id="posts">
                                            @foreach($project->comments->sortByDesc('created_at') as $comment)
                                                @include('partials.comments')
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="timeline">
                                        @include('partials.timeline')
                                    </div>

                                    <div class="tab-pane" id="settings">
                                        <div class="pull-right top-page-ui mb-15">
                                            <a href="{{route('task.form',['project_id' => $project->id])}}"
                                               class="btn btn-primary pull-right">
                                                <i class="fa fa-plus-circle fa-lg"></i> @lang('task.new')
                                            </a>
                                        </div>
                                        <table class="table table-hover">
                                            <tbody>
                                            @foreach($projectTasks as $task)
                                                <?php $project_id = $project->id;?>
                                                @include('partials.tasks')
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_footer')
    <script src="{{ asset('assets/dist/js/laravel.js') }}"></script>
    <script src="{{ asset('assets/dist/js/pages/project.js') }}"></script>
@endsection
