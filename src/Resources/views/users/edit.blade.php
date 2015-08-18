{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.users.edit.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.users.edit.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.users.edit.page_subtitle'))

{{-- Content Section --}}
@section('content')
    {!! BootForm::open()->post()->action(route('users.edit', ['id' => $user->id])) !!}

    {{-- Bind Model to Form for Filling out Inputs --}}
    {!! BootForm::bind($user) !!}

    {{-- User Box --}}
    <div class="box">
        <div class="box-body">
            {!! BootForm::text(trans('dashboard::dashboard.form.first_name'), 'first_name') !!}
            {!! BootForm::text(trans('dashboard::dashboard.form.last_name'), 'last_name') !!}
            {!! BootForm::email(trans('dashboard::dashboard.form.email'), 'email') !!}
            @if($currentRoles)
                {!! BootForm::select(trans('dashboard::dashboard.form.role') . ' <small>(' . trans('dashboard::dashboard.form.current') . ': ' . $currentRoles . ')</small>', 'role', $roles) !!}
            @else
                {!! BootForm::select(trans('dashboard::dashboard.form.role'), 'role', $roles) !!}
            @endif
        </div>
    </div>

    {{-- Include Form Actions for Edit --}}
    @include($viewNamespace . '::helpers.form.actions-edit')
    {!! BootForm::close() !!}
@stop
