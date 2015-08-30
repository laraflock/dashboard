<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ trans('dashboard::dashboard.global.actions') }}</h3>
    </div>
    <div class="box-body">
        <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-undo fa-fw"></i> {{ trans('dashboard::dashboard.buttons.reset') }}</button>
        {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.buttons.save'))->addClass('btn-sm btn-success')->removeClass('btn-default') !!}
    </div>
</div>