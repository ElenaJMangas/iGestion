<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">@choice('general.task',2)</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                <tr>
                    <th>@choice('general.project',1)</th>
                    <th>@choice('general.task',1)</th>
                    <th>@lang('general.status')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>
                            @if(!is_null($task->project_id))
                                <a href="{{ route('project',$task->project_id)}}">{{$task->project->title}}</a>
                            @endif
                        </td>
                        <td>{{$task->title}}</td>
                        <td>
                            <span class="label label-primary task {{$task->tasks_status->getColourStatus()}}">{{ __('task.'.$task->tasks_status->status) }}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer clearfix">
        <a href="{{route('tasks')}}" class="btn btn-sm btn-default btn-flat pull-right">@lang('general.all_tasks')</a>
    </div>
</div>