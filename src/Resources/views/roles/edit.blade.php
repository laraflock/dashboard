@extends($viewNamespace . '::layouts.master')
@section('title', 'Edit Role - Dashboard')
@section('page-wrapper')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                {!! BootForm::open()->delete()->action(route('roles.delete', ['id' => $role->id])) !!}
                <h2 class="page-header">Edit Role
                    {!! BootForm::submit('<i class="fa fa-trash"></i><span class="sr-only">Delete</span>')->addClass('btn btn-sm btn-danger pull-right')->data('toggle', 'tooltip')->data('placement', 'left')->title('Delete') !!}
                </h2>
                {!! BootForm::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
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
                <button type="reset" class="btn btn-sm btn-default btn-warning"><i class="fa fa-undo fa-fw"></i> Reset</button>
                {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> Save')->addClass('btn-sm btn-success') !!}
                {!! BootForm::close() !!}
            </div>
        </div>
    </div>
@stop
@section('footer-extras')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
