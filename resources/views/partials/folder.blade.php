<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">@choice('general.message.folder',2)</h3>

        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <ul id="folders" class="nav nav-pills nav-stacked">
            <li class="active" data-folder="inbox">
                <a href="#">
                    <i class="fa fa-inbox"></i> @lang('general.message.inbox')
                    @if($inbox > 0)<span class="label label-primary pull-right">{{$inbox}}</span> @endif
                </a>
            </li>
            <li data-folder="sent"><a href="#"><i class="fa fa-envelope-o"></i> @lang('general.message.sent')</a></li>
            <li data-folder="draft">
                <a href="#">
                    <i class="fa fa-file-text-o"></i> @choice('general.message.draft',2)
                    @if($drafts > 0)<span class="label label-primary pull-right">{{$drafts}}</span> @endif
                </a>
            </li>
            <li data-folder="trash"><a href="#"><i class="fa fa-trash-o"></i> @lang('general.message.trash')</a></li>
        </ul>
    </div>
</div>