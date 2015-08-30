{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.users.create.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.users.create.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.users.create.page_subtitle'))

{{-- Content Section --}}
@section('content')
    {!! BootForm::open()->post()->action(route('users.index')) !!}

    {{-- User Box --}}
    <div class="box">
        <div class="box-body">
            {!! BootForm::text(trans('dashboard::dashboard.form.first_name'), 'first_name') !!}
            {!! BootForm::text(trans('dashboard::dashboard.form.last_name'), 'last_name') !!}
            {!! BootForm::email(trans('dashboard::dashboard.form.email'), 'email') !!}
            {!! BootForm::password(trans('dashboard::dashboard.form.password'), 'password') !!}
            {!! BootForm::password(trans('dashboard::dashboard.form.confirm_password'), 'password_confirmation') !!}
            {!! BootForm::select(trans('dashboard::dashboard.form.role'), 'role', $roles) !!}
        </div>
    </div>

    {{-- Include Form Actions for Create --}}
    @include($viewNamespace . '::helpers.form.actions-create')
    {!! BootForm::close() !!}
@stop
