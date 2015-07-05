@extends('dashboard::layouts.master')
@section('title', 'Add New User - Dashboard')
@section('page-wrapper')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Add New User</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                {!! BootForm::open()->post()->action(route('users.index')) !!}
                {!! BootForm::text('First Name', 'first_name') !!}
                {!! BootForm::text('Last Name', 'last_name') !!}
                {!! BootForm::email('E-mail', 'email') !!}
                {!! BootForm::password('Password', 'password') !!}
                {!! BootForm::password('Confirm Password', 'password_confirmation') !!}
                {!! BootForm::select('Role', 'role', $roles) !!}
                <button type="reset" class="btn btn-sm btn-default btn-warning"><i class="fa fa-undo fa-fw"></i> Reset
                </button>
                {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> Save')->addClass('btn-sm btn-success') !!}
                {!! BootForm::close() !!}
            </div>
        </div>
    </div>
@stop
