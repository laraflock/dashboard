@extends($viewNamespace . '::layouts.master')
@section('title', 'Add New User - Dashboard')
@section('page-title', 'Users')
@section('page-subtitle', 'Create')
@section('content')
    <div class="box">
        <div class="box-body">
            {!! BootForm::open()->post()->action(route('users.index')) !!}
            {!! BootForm::text('First Name', 'first_name') !!}
            {!! BootForm::text('Last Name', 'last_name') !!}
            {!! BootForm::email('E-mail', 'email') !!}
            {!! BootForm::password('Password', 'password') !!}
            {!! BootForm::password('Confirm Password', 'password_confirmation') !!}
            {!! BootForm::select('Role', 'role', $roles) !!}
            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-undo fa-fw"></i> Reset
            </button>
            {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> Save')->addClass('btn-sm btn-success')->removeClass('btn-default') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
@stop
