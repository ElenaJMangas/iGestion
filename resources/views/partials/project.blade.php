<div class="col-lg-4">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ ($example) ? '#' :route('project',$project->project->id)}}">{{$project->project->title}}</a>
            </h3>
            <span class="label pull-right {{$project->project->getStatusColour()}}">{{__('project.'.$project->project->getStatus())}}</span>
        </div>
        <div class="box-body">
            <div class="team-members">
                @foreach ($members[$project->project->id] as $member)
                    <a href="{{ ($example) ? '#' : route('profile',$member->user->id)}}"><img alt="member"
                                                                                              class="img-circle"
                                                                                              src="{{\App\Helpers\Helper::getAvatarUser($member->user->avatar)}}"></a>
                @endforeach
            </div>
            <h4>{{$project->project->title}}</h4>
            <p>{{str_limit($project->project->description,550)}}</p>
            <div>
                <span>@lang('project.done'):</span>
                <div class="stat-percent">{{$percentage[$project->project->id]}}%</div>
                <div class="progress progress-mini">
                    <div style="width: {{$percentage[$project->project->id]}}%" class="progress-bar"></div>
                </div>
            </div>
            <div class="row  m-t-sm">
                <div class="col-sm-4">
                    <div class="font-bold">@choice('general.task',2)</div>
                    {{count($tasks[$project->project->id])}}
                </div>
                <div class="col-sm-4">
                    <div class="font-bold">@choice('project.member',2)</div>
                    {{count($members[$project->project->id])}}
                </div>
            </div>

        </div>
    </div>
</div>