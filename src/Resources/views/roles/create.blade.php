@extends('dashboard::layouts.master')
@section('title', 'Add New Role - Dashboard')
@section('page-wrapper')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Add New Role</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                {!! BootForm::open()->post()->action(route('roles.index')) !!}
                {!! BootForm::text('Name', 'name') !!}
                {!! BootForm::text('Slug', 'slug') !!}
                <div class="form-group">
                    <label>Permissions</label>

                    <div class="clearfix"></div>

                    @foreach($permissions as $permission)
                        {!! BootForm::inlineCheckbox($permission->name, "permissions[{$permission->slug}]") !!}
                    @endforeach
                </div>
                <button type="reset" class="btn btn-sm btn-default btn-warning"><i class="fa fa-undo fa-fw"></i> Reset</button>
                {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> Save')->addClass('btn-sm btn-success') !!}
                {!! BootForm::close() !!}
            </div>
        </div>
    </div>
@stop
