@extends('dashboard::layouts.master')
@section('title', 'Edit Account - Dashboard')
@section('page-wrapper')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Edit Account</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                {!! BootForm::open()->put()->action(route('account.edit', ['id' => $activeUser->id])) !!}
                {!! BootForm::bind($activeUser) !!}
                {!! BootForm::text('First Name', 'first_name') !!}
                {!! BootForm::text('Last Name', 'last_name') !!}
                {!! BootForm::email('E-mail', 'email') !!}
                {!! BootForm::submit('Update Account')->addClass('btn-success') !!}
                {!! BootForm::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Change Password</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                {!! BootForm::open()->put()->action(route('account.edit', ['id' => $activeUser->id])) !!}
                {!! BootForm::password('Old Password', 'old_password') !!}
                {!! BootForm::password('New Password', 'new_password') !!}
                {!! BootForm::password('Confirm Password', 'confirm_password') !!}
                {!! BootForm::submit('Change Password')->addClass('btn-success') !!}
                {!! BootForm::close() !!}
            </div>
        </div>
    </div>
@stop
