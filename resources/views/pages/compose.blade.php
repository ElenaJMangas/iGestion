@extends('layouts.app')

@section('title', __('titles.messages'))

@section('meta_keywords','messages')

@section('meta_description','Messages')

@section('pagecss')
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') }}"/>

    <!-- Tags Input -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"/>
@endsection

@section('content')
@section('header_title', __('titles.messages'))

{{-- Row 1 --}}
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('general.message.compose')</h3>
            </div>
            <form role="form"
                  action="#" method="POST">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <input name="to" id="to" class="form-control" placeholder="@lang('task.to')">
                    </div>
                    <div class="form-group">
                        <input name="subject" class="form-control" placeholder="@lang('general.message.subject')"
                               required
                               value="{{ isset($message) ? ($message->status == 1 ? __('general.message.replySubject')." ".$message->subject : $message->subject) : old('subject') }}">
                    </div>
                    <div class="form-group">
                        <textarea name="message" id="compose-textarea" class="form-control" style="height: 300px"
                                  required>{{ isset($message) ? ($message->status == 1 ? "" : $message->message) : old('message') }}</textarea>
                    </div>
                    <input type="hidden" id="message_id" name="message_id" value="{{isset($message) ? $message->id : ''}}">
                    <input type="hidden" id="user_id" value="{{isset($message) ? $message->user_id : ''}}">
                    <input type="hidden" id="display_name"
                           value="{{isset($message) ? $message->user->getFullName() : ''}}">
                    <input type="hidden" name="draft" value="{{isset($message) ? ($message->status == 1 ? 0 : 1 ): 0}}">
                </div>

                <div class="box-footer">
                    <div class="pull-right">
                        <button id="draft" type="submit" class="btn btn-default" data-action="{{route('draft')}}">
                            <i class="fa fa-pencil"></i> @choice('general.message.draft',1)</button>

                        <button id="send" type="submit" class="btn btn-primary" data-action="{{route('send')}}">
                            <i class="fa fa-envelope-o"></i> @lang('general.message.send')</button>
                    </div>
                    <a href="{{route('messages')}}" class="btn btn-default">@lang('general.cancel')</a>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('after_footer')

    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('assets/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

    <!-- Tags Input -->
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

    <!-- Typeahead -->
    <script src="{{ asset('assets/plugins/typeahead/typeahead.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/pages/compose.js') }}"></script>
@endsection
