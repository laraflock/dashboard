@extends($viewNamespace . '::layouts.master')
@section('title', 'Edit Role - Dashboard')
@section('page-title', 'Roles')
@section('page-subtitle', 'Edit')
@section('content')
    <div class="box">
        <div class="box-body">
            {!! BootForm::open()->post()->action(route('roles.edit', ['id' => $role->id])) !!}
            {!! BootForm::bind($role) !!}
            {!! BootForm::text('Name', 'name') !!}
            {!! BootForm::text('Slug', 'slug') !!}
            <div class="form-group">
                <label>Permissions</label>

                <div class="clearfix"></div>
                @foreach($permissions as $permission)
                    @if(is_array($role->permissions) && array_key_exists($permission->slug, $role->permissions))
                        {!! BootForm::inlineCheckbox($permission->name, "permissions[{$permission->slug}]")->check() !!}
                    @else
                        {!! BootForm::inlineCheckbox($permission->name, "permissions[{$permission->slug}]") !!}
                    @endif
                @endforeach
            </div>
            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-undo fa-fw"></i> Reset</button>
            {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> Save')->addClass('btn-sm btn-success')->removeClass('btn-default') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
@stop
