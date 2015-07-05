@extends('dashboard::layouts.master')
@section('title', 'Edit Permission - Dashboard')
@section('page-wrapper')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                {!! BootForm::open()->delete()->action(route('permissions.delete', ['id' => $permission->id])) !!}
                <h2 class="page-header">Edit Permission
                    {!! BootForm::submit('<i class="fa fa-trash"></i><span class="sr-only">Delete</span>')->addClass('btn btn-sm btn-danger pull-right')->data('toggle', 'tooltip')->data('placement', 'left')->title('Delete') !!}
                </h2>
                {!! BootForm::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                {!! BootForm::open()->post()->action(route('permissions.edit', ['id' => $permission->id])) !!}
                {!! BootForm::bind($permission) !!}
                {!! BootForm::text('Name', 'name') !!}
                {!! BootForm::text('Slug', 'slug') !!}
                <button type="reset" class="btn btn-sm btn-default btn-warning"><i class="fa fa-undo fa-fw"></i> Reset
                </button>
                {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> Save')->addClass('btn-sm btn-success') !!}
                {!! BootForm::close() !!}
            </div>
        </div>
    </div>
@stop
@section('footer-extras')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
