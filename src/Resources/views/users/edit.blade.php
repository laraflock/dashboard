@extends('dashboard::layouts.master')
@section('title', 'Edit User - Dashboard')
@section('page-wrapper')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                {!! BootForm::open()->delete()->action(route('users.delete', ['id' => $user->id])) !!}
                <h2 class="page-header">Edit User
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
                {!! BootForm::open()->post()->action(route('users.edit', ['id' => $user->id])) !!}
                {!! BootForm::bind($user) !!}
                {!! BootForm::text('First Name', 'first_name') !!}
                {!! BootForm::text('Last Name', 'last_name') !!}
                {!! BootForm::email('E-mail', 'email') !!}
                @if($currentRoles)
                    {!! BootForm::select('Role <small>(Current: ' . $currentRoles . ')</small>', 'role', $roles) !!}
                @else
                    {!! BootForm::select('Role', 'role', $roles) !!}
                @endif
                <button type="reset" class="btn btn-sm btn-default btn-warning"><i class="fa fa-undo fa-fw"></i> Reset
                </button>
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
