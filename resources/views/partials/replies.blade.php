<?php /** @var \App\Models\Repply $reply */ ?>
<div class="post clearfix mt-30 ml-50 post-reply">
    <div class="user-block">
        <img class="img-circle img-bordered-sm" src="{{ \App\Helpers\Helper::getAvatarUser($reply) }}"
             alt="{{ $reply->user->getFullName() }}">
        <span class="username">
            <a href="{{route('profile',['id'=>$reply->user_id])}}">{{$reply->user->getFullName()}}</a>
            <a href="{{route('reply.delete',['id' => $reply->id])}}" class="pull-right btn-box-tool"
               data-confirm="@lang('general.sure')" data-method="delete" data-toggle="tooltip" title="@lang('general.delete')">
                <i class="fa fa-times"></i>
            </a>
        </span>
        <span class="description">{{\App\Helpers\Helper::formatDate($reply->created_at)}}</span>
    </div>
    <p>
        {{ $reply->comment }}
    </p>
</div>