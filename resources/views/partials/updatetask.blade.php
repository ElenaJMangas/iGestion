@if(isset($task->id))
    <input name="_method" type="hidden" value="PUT">
@endif
<div class="box-body">
    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
        <label for="title" class="col-sm-2 control-label">@lang('task.title')</label>

        <div class="col-sm-10">
            <input type="text" name='title'
                   value="{{ isset($task->title) ?  $task->title : old('title')  }}"
                   class="form-control" id="title" placeholder="@lang('task.title')" required
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
               class="col-sm-2 control-label">@lang('task.description')</label>

        <div class="col-sm-10">
                                    <textarea required name="description" class="form-control" rows="5"
                                              placeholder="@lang('task.description')">{{ isset($task->description) ?  $task->description : old('description')  }}</textarea>
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
            {{ Form::select('priority', $priorities, isset($task->priority_id) ? $task->priority_id : old('priority'), ['class' => 'form-control','required'])}}
        </div>
    </div>
    <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
        <label for="status" class="col-sm-2 control-label">@lang('general.status')</label>
        <div class="col-sm-10">
            {{ Form::select('status', $status, isset($task->status_id) ? $task->status_id : old('status'), ['class' => 'form-control', 'required'])}}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="when">@lang('task.targetEndDate')</label>

        <div class="datepick date col-sm-10">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="datetimepicker"
                   name="datetimepicker" @if(!\Auth::user()->isAdmin() && $task->user_id != \Auth::user()->id) disabled @endif>
            <input type="text" class="hide" id="datetimepickerdefault"
                   value="{{ isset($task->target_end_date) ?  $task->target_end_date : old('datetimepicker')  }}">
        </div>
    </div>
    @if (\Auth::user()->isAdmin())
        <div class="form-group">
            <label class="col-sm-2 control-label" for="to">@lang('task.to')</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="to" id="to"
                       data-role="tagsinput"/>
                @if(isset($task->id))
                    @foreach($task->tasks_users as $task_user)
                        @if($task_user->user->id != \Auth::user()->id)
                            <input class="recipients" type="hidden"
                                   value="{{$task_user->user->id.",".$task_user->user->getFullName()}}"/>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    @endif
</div>