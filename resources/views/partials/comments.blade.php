<?php /** @var \App\Models\Comment $comment */ ?>
<div class="post">
    <div class="user-block">
        <img class="img-circle img-bordered-sm"
             src="{{\App\Helpers\Helper::getAvatarUser($comment)}}" alt="{{$comment->user->getFullName()}}">
        <span class="username">
             <a href="{{route('profile',['id'=>$comment->user_id])}}">{{$comment->user->getFullName()}}</a>
            <a href="{{route('comment.delete',['id' => $comment->id])}}" class="pull-right btn-box-tool"
               data-confirm="@lang('general.sure')" data-method="delete" data-toggle="tooltip" title="@lang('general.delete')"><i
                        class="fa fa-times"></i></a>
        </span>
        <span class="description">{{\App\Helpers\Helper::formatDate($comment->created_at)}}</span>
    </div>
    <p>
        {{$comment->comment}}
    </p>
    @if(count($comment->replies) > 0)

        <div id="accordion" class="link-black text-sm">
            <div class="box-header with-border">
                <h4 class="box-title pull-right">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$comment->id}}"
                       aria-expanded="false"
                       class="collapsed link-black text-sm">
                        <i class="fa fa-comments-o margin-r-5"></i> @choice('project.reply',2)
                        ({{count($comment->replies)}})
                    </a>
                </h4>
            </div>
            <div id="collapse{{$comment->id}}" class="panel-collapse collapse" aria-expanded="false"
                 style="height: 0px;">
                <div class="box-body">
                    @foreach($comment->replies as $reply)
                        @include('partials.replies')
                    @endforeach
                </div>
            </div>
        </div>

    @endif

    {{Form::open(['route' => ['reply', $comment->id], 'method' => 'post','class'=>'form-horizontal'])}}
    <input name="reply" class="form-control input-sm reply" type="text"
           placeholder="@lang('project.type')">
    {{ Form::close() }}
</div>