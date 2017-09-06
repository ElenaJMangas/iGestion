@extends('layouts.app')

@section('title', __('titles.messages'))
@section('meta_keywords','messages')
@section('meta_description','Messages')

@section('pagecss')
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/iCheck/square/blue.css') }}">
@endsection

@section('content')
@section('header_title', __('titles.messages'))

{{-- Row 1 --}}
<div class="row">
    <div class="col-md-3">
        <a href="{{ route('compose') }}"
           class="btn btn-primary btn-block margin-bottom">@lang('general.message.compose')</a>
        @include('partials.folder')
    </div>

    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('general.message.inbox')</h3>
            </div>

            <div class="box-body">
                <div class="mailbox-messages">
                    <table id="messages" class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>@choice('general.user',1)</th>
                            <th>@lang('general.message.subject')</th>
                            <th>@lang('general.date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <div class="loading"></div>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer no-padding">
                <div class="mailbox-controls">
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                    </button>
                    <div class="btn-group">
                        {{ Form::open(['route' => ['messages.delete'],'id'=>'delete', 'method' => 'delete','class'=>'inline','onsubmit' => 'return deleteMessage()']) }}
                        <button type="submit" class="btn btn-default btn-sm trash" disabled><i
                                    class="fa fa-trash-o"></i></button>
                        {{ Form::close() }}
                        <form class="inline" action="{{route('compose.reply')}}" id="reply" onsubmit="return reply()"
                              method="POST">
                            <input type="hidden" name="message_id" value="">
                            <button type="submit" class="btn btn-default btn-sm reply" disabled><i
                                        class="fa fa-reply"></i></button>
                        </form>
                    </div>
                    <button type="button" class="btn btn-default btn-sm refresh" data-folder=""><i
                                class="fa fa-refresh"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('after_footer')
    <!-- iCheck -->
    <script src="{{ asset('assets/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/icheck.js') }}"></script>
    <script src="{{ asset('assets/dist/js/pages/messages.js') }}"></script>
@endsection
