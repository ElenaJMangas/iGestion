@extends('layouts.app')

@section('title', __('titles.messages'))
@section('meta_keywords','messages')
@section('meta_description','Messages')

@section('pagecss')

@endsection

@section('content')
@section('header_title', __('titles.messages'))
<?php  /** @var \App\Models\Message $message */?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border no-print">
                <h3 class="box-title">@lang('general.message.read')</h3>
            </div>
            <div class="box-body no-padding" id="message">
                <div class="mailbox-read-info">
                    <h3>{{ $message->subject }}</h3>
                    <h5>@lang('general.message.from'): {{ $message->user->getFullName() }}
                        <span class="mailbox-read-time pull-right">{{ $message->date_sent->format(\App\Helpers\Helper::getFormatLocale()) }}</span>
                    </h5>
                </div>
                <div class="mailbox-controls with-border text-center no-print">
                    <div class="btn-group">
                        {{ Form::open(['route' => ['messages.delete'],'id'=>'delete', 'method' => 'delete','class'=>'inline']) }}
                        <input type="hidden" name="delete[]" value="{{$message->id}}">
                        <button type="submit" class="btn btn-default btn-sm trash"><i
                                    class="fa fa-trash-o"></i></button>
                        {{ Form::close() }}
                        @if($message->user_id != \Auth::user()->id)
                            <form class="inline" action="{{route('compose.reply')}}" method="POST">
                                <input type="hidden" name="message_id" value="{{$message->id}}">
                                <button type="submit" class="btn btn-default btn-sm reply" data-toggle="tooltip"
                                        data-container="body"
                                        title="" data-original-title="@lang('general.message.reply')">
                                    <i class="fa fa-reply"></i></button>
                            </form>
                        @endif
                    </div>
                    <button type="button" class="btn btn-default btn-sm print" data-toggle="tooltip" title=""
                            data-original-title="@lang('general.message.print')">
                        <i class="fa fa-print"></i></button>
                </div>
                <div class="mailbox-read-message">
                    {!! $message->message  !!}
                </div>
            </div>
            <div class="box-footer no-print">
                <div class="pull-right">
                    <button type="button" class="btn btn-default print"><i
                                class="fa fa-print"></i> @lang('general.message.print')</button>
                    @if($message->user_id != \Auth::user()->id)
                        <form class="inline" action="{{route('compose.reply')}}" method="POST">
                            <input type="hidden" name="message_id" value="{{$message->id}}">
                            <button type="submit" class="btn btn-default reply"><i
                                        class="fa fa-reply"></i> @lang('general.message.reply')</button>
                        </form>
                    @endif
                </div>
                <a href="{{route('messages')}}" class="btn btn-default">@lang('general.cancel')</a>
                {{ Form::open(['route' => ['messages.delete'],'id'=>'delete', 'method' => 'delete','class'=>'inline']) }}
                <input type="hidden" name="delete[]" value="{{$message->id}}">
                <button type="submit" class="btn btn-default"><i
                            class="fa fa-trash-o"></i> @lang('general.delete')</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>


@endsection

@section('after_footer')
    <script src="{{ asset('assets/dist/js/pages/message.js') }}"></script>
@endsection
