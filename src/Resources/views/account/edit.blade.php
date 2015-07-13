@extends($viewNamespace . '::layouts.master')
@section('title', 'Edit Profile - Dashboard')
@section('page-title', 'Profile')
@section('page-subtitle', 'Edit')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Account</h3>
        </div>
        <div class="box-body">
            {!! BootForm::open()->post()->action(route('account.update', ['id' => $activeUser->id])) !!}
            {!! BootForm::hidden('action')->value('update_account') !!}
            {!! BootForm::bind($activeUser) !!}
            {!! BootForm::text('First Name', 'first_name') !!}
            {!! BootForm::text('Last Name', 'last_name') !!}
            {!! BootForm::email('E-mail', 'email') !!}
            {!! BootForm::submit('Update Account', 'update_account')->addClass('btn-success')->removeClass('btn-default') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Change Password</h3>
        </div>
        <div class="box-body">
            {!! BootForm::open()->post()->action(route('account.update', ['id' => $activeUser->id])) !!}
            {!! BootForm::hidden('action')->value('change_password') !!}
            {!! BootForm::hidden('email')->value($activeUser->email) !!}
            {!! BootForm::password('Old Password', 'password') !!}
            {!! BootForm::password('New Password', 'new_password') !!}
            {!! BootForm::password('Confirm Password', 'new_password_confirmation') !!}
            {!! BootForm::submit('Change Password', 'change_password')->addClass('btn-success')->removeClass('btn-default') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
@stop
