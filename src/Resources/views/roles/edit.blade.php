{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.roles.edit.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.roles.edit.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.roles.edit.page_subtitle'))

{{-- Content Section --}}
@section('content')
    {!! BootForm::open()->post()->action(route('roles.edit', ['id' => $role->id])) !!}

    {{-- Bind Model to Form for Filling out Inputs --}}
    {!! BootForm::bind($role) !!}

    {{-- Role Box --}}
    <div class="box">
        <div class="box-body">
            {!! BootForm::text(trans('dashboard::dashboard.form.name'), 'name') !!}
            {!! BootForm::text(trans('dashboard::dashboard.form.slug'), 'slug') !!}
            <div class="form-group">
                <label>{{ trans('dashboard::dashboard.form.permissions') }}</label>

                <div class="clearfix"></div>
                @foreach($permissions as $permission)
                    @if(is_array($role->permissions) && array_key_exists($permission->slug, $role->permissions))
                        {!! BootForm::inlineCheckbox($permission->name, "permissions[{$permission->slug}]")->check() !!}
                    @else
                        {!! BootForm::inlineCheckbox($permission->name, "permissions[{$permission->slug}]") !!}
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- Include Form Actions for Edit --}}
    @include($viewNamespace . '::helpers.form.actions-edit')
    {!! BootForm::close() !!}
@stop
