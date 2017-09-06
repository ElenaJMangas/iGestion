<div class="box box-solid bg-light-blue-gradient">
    <div class="box-header">
        <i class="fa fa-calendar"></i>

        <h3 class="box-title">@lang('general.calendar')</h3>
        <div class="pull-right box-tools">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bars"></i></button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="{{ route('calendar') }}">@lang('general.all_calendar')</a></li>
                </ul>
            </div>
            <button type="button" class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <div id="calendar" style="width: 100%"></div>
    </div>
    <div class="box-footer text-black">
        <div class="row">
            @foreach($monthTasks as $task)
                <div class="col-sm-6">
                    <div class="clearfix">
                        <span class="pull-left text-light-blue">{{$task->title}}</span>
                        <span class="pull-right text-muted">{{ \App\Helpers\Helper::formatDate($task->target_end_date) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>