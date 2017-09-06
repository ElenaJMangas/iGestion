<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">@choice('project.member',2)</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
        </div>
    </div>

    <div class="box-body no-padding">
        <ul class="users-list clearfix">
            @foreach($members as $member)
                <li>
                    <img src="{{\App\Helpers\Helper::getAvatarUser($member->avatar)}}" alt="member">
                    <a class="users-list-name" href="{{route('profile',$member->id)}}">{{$member->getFullName()}}</a>
                    <span class="users-list-date">@lang('general.memberSince') {{ App\Helpers\Helper::getMonth($member->created_at) . ". " . App\Helpers\Helper::getYear($member->created_at)}}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="box-footer text-center">
        <a href="{{route('admin.user')}}" class="uppercase">@lang('general.all_users')</a>
    </div>
</div>