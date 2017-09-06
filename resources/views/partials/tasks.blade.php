<tr>
    <td class="project-status">
        <span class="label label-primary task {{ $task->tasks_status->getColourStatus() }}">{{ __('task.'.$task->tasks_status->status) }}</span>
    </td>
    <td class="project-title">
        <a href="{{$example ? '#' : route('task',['id' => $task->id,'action' => 'detail'])}}">{{ $task->title }}</a>
        <br>
        @if(!empty($task->target_end_date))
            <small>@lang('task.targetEndDate'): {{$task->getTargetEndDate()}}</small>
        @endif
    </td>
    <td class="project-completion">
        @if (!is_null($task->target_end_date))
            <?php $taskcompletion = $task->getTaskCompletion();?>
            @if(isset($taskcompletion['days']))
                <small>
                    @if($taskcompletion['finished'])
                        @if($taskcompletion['success'])
                            @lang('task.advance')
                        @else
                            @lang('task.delay')
                        @endif
                    @else
                        @if($taskcompletion['days'] < 0)
                            @lang('task.delay')
                        @else
                            @lang('task.left')
                        @endif
                    @endif
                    {{abs($taskcompletion['days'])}} @lang('task.days')</small>
            @endif
            <div class="progress progress-mini @if ($taskcompletion['success']) {{'progress-bar-green'}} @else {{'progress-bar-danger'}} @endif">
                <div class="progress-bar"></div>
            </div>
        @endif
    </td>
    <td class="task-members">
        @foreach ($task->tasks_users as $member)
            <a href="{{$example ? '#' : route('profile',$member->user->id)}}"><img
                        alt="{{$member->user->getFullName()}}" class="img-circle"
                        src="{{\App\Helpers\Helper::getAvatarUser($member->user->avatar)}}"></a>
        @endforeach
    </td>
    <td class="actions">
        <a href="{{$example ? '#' : route('task',['id' => $task->id,'action' => 'detail'])}}"
           class="table-link ">
															<span class="fa-stack" data-toggle="tooltip"
                                                                  title="@choice('general.detail',2)">
																<i class="fa fa-square fa-stack-2x"></i>
																<i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
															</span>
        </a>
        @if($task->status_id != 3)
            <a class="view-details table-link"
               href="{{$example ? '#' :  route('task',['id' => $task->id,'action' => 'update'])}}">
                                                    <span class="fa-stack" data-toggle="tooltip"
                                                          title="@lang('general.update')">
                                                        <i class="fa fa-square fa-stack-2x"></i>
                                                        <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                                    </span>
            </a>
        @endif
        @if (\Auth::user()->isAdmin() || $task->user_id == \Auth::user()->id)
            {{ $example ? Form::open(['class'=>'icons']) : Form::open(['route' => ['task.delete'], 'method' => 'delete','class'=>'icons','onsubmit' => 'return confirm("'.__('general.sure').'")']) }}
            <input type="hidden" name="id" value="{{$task->id}}"/>
            <button type="submit" class="danger">
                                            <span class="fa-stack" data-toggle="tooltip"
                                                  title="@lang('general.delete')">
                                                        <i class="fa fa-square fa-stack-2x"></i>
                                                        <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                    </span>
            </button>
            {{ Form::close() }}
        @endif
    </td>
</tr>
