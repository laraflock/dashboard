@extends($viewNamespace . '::layouts.master')
@section('title', 'Users - Dashboard')
@section('header-extras')
    {{-- Data Tables Styles --}}
    <link href="{{ asset('vendor/odotmedia/data-tables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/odotmedia/data-tables/css/dataTables.responsive.css') }}" rel="stylesheet" type="text/css">
@stop
@section('page-wrapper')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Users
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-default pull-right" data-toggle="tooltip" data-placement="left" title="Add New User"><i class="fa fa-plus"></i></a>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('flash::message')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-users">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>First</th>
                                <th>Last</th>
                                <th>E-mail</th>
                                <th>Role</th>
                                <th class="datatable-nosort">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr class="">
                                    <td class="text-center col-xs-1">
                                        <a href="{{ route('users.edit', ['id' => $user->id]) }}">{{ $user->id }}</a>
                                    </td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <div>{{ $role->name }}</div>
                                        @endforeach
                                    </td>
                                    <td class="text-center col-xs-1">
                                        {!! BootForm::open()->delete()->action(route('users.delete', ['id' => $user->id])) !!}
                                        <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                        {!! BootForm::submit('<i class="fa fa-trash"></i><span class="sr-only">Delete</span>')->addClass('btn btn-xs btn-danger')->data('toggle', 'tooltip')->data('placement', 'top')->title('Delete') !!}
                                        {!! BootForm::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer-extras')
    <script src="{{ asset('vendor/odotmedia/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/odotmedia/data-tables/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('#dataTables-users').DataTable({
                responsive: true,
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false
                }]
            });
        });
    </script>
@stop