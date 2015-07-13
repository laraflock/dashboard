@extends($viewNamespace . '::layouts.master')
@section('title', 'Add New Permission - Dashboard')
@section('page-title', 'Permissions')
@section('page-subtitle', 'Create')
@section('content')
    <div class="box">
        <div class="box-body">
            {!! BootForm::open()->post()->action(route('permissions.index')) !!}
            {!! BootForm::text('Name', 'name') !!}
            {!! BootForm::text('Slug', 'slug') !!}
            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-undo fa-fw"></i> Reset</button>
            {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> Save')->addClass('btn-sm btn-success')->removeClass('btn-default') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
@stop
