<li class="header">@choice('general.notification',2) {{ \App\Models\Notification::getNotRead() }}</li>
<li>
    <?php
    $notifications = \App\Models\Notification::getList(); ?>
    <ul class="menu">
        @foreach($notifications as $notification)
            <li>
                <a href="{{ route('notifications.read', $notification->notification->id) }}">
                    <i class="ion ion-ios-people info"></i> {{ $notification->notification->notification }}
                </a>
            </li>
        @endforeach
    </ul>
</li>
<li class="footer"><a href="{{ route('notifications') }}">@lang('general.all_notifications')</a></li>
