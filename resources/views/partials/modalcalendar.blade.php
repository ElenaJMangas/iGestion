<div class="modal-dialog">
    <div class="modal-content">
        <form id="eventdetails" class="form-horizontal" role="form"
              action="{{route('event.save', isset($event->id) ? $event->id : NULL)}}"
              method="POST">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h4 class="modal-title">title</h4>
            </div>
            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="title">@lang('calendar.title'):</label>
                    <div class="controls">
                        <input required class="form-control" type="text" name="title" id="title"
                               placeholder="@lang('calendar.title')">
                    </div>
                </div>
                <div class="control-group col-xs-12" id="dates">
                    <div class="control-group col-xs-8">
                        <label class="control-label" for="startDate">@lang('calendar.startDate')
                            :</label>
                        <div class='input-group date'>
                            <input type="text" class="form-control date start" id="startDate" name="startDate"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="control-group col-xs-4">
                        <label class="control-label"
                               for="timepickerStart">@lang('calendar.startTime')
                            :</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input type="text" class="time start form-control input-small"
                                   id="timepickerStart" name="timepickerStart"/>
                            <span class="input-group-addon"><i
                                        class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </div>
                    <div class="control-group col-xs-8">
                        <label class="control-label" for="endDate">@lang('calendar.endDate')
                            :</label>
                        <div class='input-group date'>
                            <input type="text" class="date end form-control" id="endDate" name="endDate"/>
                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                        </div>
                    </div>
                    <div class="control-group col-xs-4">
                        <label class="control-label" for="timepickerEnd">@lang('calendar.endTime')
                            :</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input type="text" class="time end form-control input-small"
                                   id="timepickerEnd" name="timepickerEnd"/>
                            <span class="input-group-addon"><i
                                        class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </div>
                </div>
                <div class="control-group col-xs-12">
                    <div class="controls">
                        <div class="checkbox icheck">
                            <label><input type="checkbox" id="allDay"
                                          name="allDay">
                                @lang('calendar.allDayEvent')</label>
                        </div>
                    </div>
                </div>
                <div class="control-group clearfix">
                    <label class="control-label" for="description">@lang('calendar.description')
                        :</label>

                    <div class='input-group textarea'>
                                            <textarea name="description" class="form-control" rows="5"
                                                      placeholder="@lang('calendar.description')"></textarea>
                    </div>
                </div>
                <div class="control-group clearfix">
                    <label class="control-label" for="legend">@lang('calendar.legend'):</label>
                    <div class='input-group select'>
                        <select name="legend" id="legend">
                            @foreach ($legends as $legend)
                                <option value="{{$legend->id}}"
                                        class="{{$legend->colour}}" @if ($legend->id == 1) {{'selected'}} @endif >{{ __('general.categories.'.$legend->category) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if (\Auth::user()->isAdmin())
                    <div class="control-group clearfix">
                        <label class="control-label" for="to">@lang('calendar.to'):</label>
                        <div class='input-group select'>
                            <input class="form-control" type="text" name="to" id="to"
                                   data-role="tagsinput"/>

                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <a id="delete" class="btn btn-danger pull-left" data-method="delete"
                   data-confirm="@lang('general.sure')"
                   href="{{route('event.delete',['id' =>0])}}">@lang('general.delete')
                </a>
                <button class="btn" data-dismiss="modal" aria-hidden="true">@lang('general.cancel')</button>
                <button type="submit" class="btn btn-primary" id="submitButton">@lang('general.save')</button>
            </div>
        </form>
    </div>
</div>