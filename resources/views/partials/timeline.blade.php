<ul class="timeline timeline-inverse">
    @foreach($notifications as $key => $value )
        <li class="time-label">
            <span class="bg-red">
                {{$key}}
            </span>
        </li>
        @foreach($value as $notification)
            <li>
                <i class="fa {{$notification->getIcon()}}"></i>

                <div class="timeline-item">
                    <span class="time">
                        <i class="fa fa-clock-o"></i>
                        {{\App\Helpers\Helper::formatHour($notification->created_at)}}</span>

                    <h3 class="timeline-header no-border">{{$notification->notification}}</h3>
                </div>
            </li>
        @endforeach
    @endforeach
    <li>
        <i class="fa fa-clock-o bg-gray"></i>
    </li>
</ul>