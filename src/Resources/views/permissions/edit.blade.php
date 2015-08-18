{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', trans('laraflock.dashboard.permissions.edit.title'))

{{-- Page Title --}}
@section('page-title', trans('laraflock.dashboard.permissions.edit.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('laraflock.dashboard.permissions.edit.page_subtitle'))

{{-- Content Section --}}
@section('content')
    {!! BootForm::open()->post()->action(route('permissions.edit', ['id' => $permission->id])) !!}

    {{-- Bind Model to Form for Filling out Inputs --}}
    {!! BootForm::bind($permission) !!}

    {{-- Permission Box --}}
    <div class="box">
        <div class="box-body">
            {!! BootForm::text(trans('laraflock.dashboard.form.name'), 'name') !!}
            {!! BootForm::text(trans('laraflock.dashboard.form.slug'), 'slug') !!}
        </div>
    </div>

    {{-- Include Form Actions for Edit --}}
    @include($viewNamespace . '::helpers.form.actions-edit')
    {!! BootForm::close() !!}
@stop
