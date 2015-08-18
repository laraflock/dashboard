{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', trans('laraflock.dashboard.account.title'))

{{-- Page Title --}}
@section('page-title', trans('laraflock.dashboard.account.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('laraflock.dashboard.account.page_subtitle'))

{{-- Content Section --}}
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('laraflock.dashboard.account.edit_profile_title') }}</h3>
        </div>
        <div class="box-body">
            {!! BootForm::open()->post()->action(route('account.update', ['id' => $activeUser->id])) !!}
            {!! BootForm::hidden('action')->value('update_account') !!}
            {!! BootForm::bind($activeUser) !!}
            {!! BootForm::text(trans('laraflock.dashboard.form.first_name'), 'first_name') !!}
            {!! BootForm::text(trans('laraflock.dashboard.form.last_name'), 'last_name') !!}
            {!! BootForm::email(trans('laraflock.dashboard.form.email'), 'email') !!}
            {!! BootForm::submit(trans('laraflock.dashboard.buttons.update_account'), 'update_account')->addClass('btn-success')->removeClass('btn-default') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('laraflock.dashboard.account.change_pass_title') }}</h3>
        </div>
        <div class="box-body">
            {!! BootForm::open()->post()->action(route('account.update', ['id' => $activeUser->id])) !!}
            {!! BootForm::hidden('action')->value('change_password') !!}
            {!! BootForm::hidden('email')->value($activeUser->email) !!}
            {!! BootForm::password(trans('laraflock.dashboard.form.old_password'), 'password') !!}
            {!! BootForm::password(trans('laraflock.dashboard.form.new_password'), 'new_password') !!}
            {!! BootForm::password(trans('laraflock.dashboard.form.confirm_password'), 'new_password_confirmation') !!}
            {!! BootForm::submit(trans('laraflock.dashboard.buttons.change_password'), 'change_password')->addClass('btn-success')->removeClass('btn-default') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
@stop
