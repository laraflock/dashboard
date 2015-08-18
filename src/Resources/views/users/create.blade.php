{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', trans('laraflock.dashboard.users.create.title'))

{{-- Page Title --}}
@section('page-title', trans('laraflock.dashboard.users.create.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('laraflock.dashboard.users.create.page_subtitle'))

{{-- Content Section --}}
@section('content')
    {!! BootForm::open()->post()->action(route('users.index')) !!}

    {{-- User Box --}}
    <div class="box">
        <div class="box-body">
            {!! BootForm::text(trans('laraflock.dashboard.form.first_name'), 'first_name') !!}
            {!! BootForm::text(trans('laraflock.dashboard.form.last_name'), 'last_name') !!}
            {!! BootForm::email(trans('laraflock.dashboard.form.email'), 'email') !!}
            {!! BootForm::password(trans('laraflock.dashboard.form.password'), 'password') !!}
            {!! BootForm::password(trans('laraflock.dashboard.form.confirm_password'), 'password_confirmation') !!}
            {!! BootForm::select(trans('laraflock.dashboard.form.role'), 'role', $roles) !!}
        </div>
    </div>

    {{-- Include Form Actions for Create --}}
    @include($viewNamespace . '::helpers.form.actions-create')
    {!! BootForm::close() !!}
@stop
