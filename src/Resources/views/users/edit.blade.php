@extends($viewNamespace . '::layouts.master')
@section('title', 'Edit User - Dashboard')
@section('page-title', 'Users')
@section('page-subtitle', 'Edit')
@section('content')
    <div class="box">
        <div class="box-body">
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
            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-undo fa-fw"></i> Reset
            </button>
            {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> Save')->addClass('btn-sm btn-success')->removeClass('btn-default') !!}
            {!! BootForm::close() !!}
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

