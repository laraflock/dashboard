{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.roles.create.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.roles.create.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.roles.create.page_subtitle'))

{{-- Content Section --}}
@section('content')
    {!! BootForm::open()->post()->action(route('roles.index')) !!}

    {{-- Role Box --}}
    <div class="box">
        <div class="box-body">
            {!! BootForm::text(trans('dashboard::dashboard.form.name'), 'name') !!}
            {!! BootForm::text(trans('dashboard::dashboard.form.slug'), 'slug') !!}
            <div class="form-group">
                <label>{{ trans('dashboard::dashboard.form.permissions') }}</label>

                <div class="clearfix"></div>

                @foreach($permissions as $permission)
                    {!! BootForm::inlineCheckbox($permission->name, "permissions[{$permission->slug}]") !!}
                @endforeach
            </div>
        </div>
    </div>

    {{-- Include Form Actions for Create --}}
    @include($viewNamespace . '::helpers.form.actions-create')
    {!! BootForm::close() !!}
@stop
