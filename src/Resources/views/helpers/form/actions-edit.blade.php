<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ trans('laraflock.dashboard.global.actions') }}</h3>
    </div>
    <div class="box-body">
        {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('laraflock.dashboard.buttons.save'))->addClass('btn-sm btn-success')->removeClass('btn-default') !!}
    </div>
</div>