@extends($viewNamespace . '::layouts.master')
@section('title', 'Users - Dashboard')
@section('page-title', 'Users')
@section('page-subtitle', 'All Users')
@section('header-extras')
    {{-- Data Table Styles --}}
    <link href="{{ asset('vendor/odotmedia/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
@stop
@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Users</h3>
        </div>
        <div class="box-body">
            <table id="users" class="table table-bordered table-striped">
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
                            {!! BootForm::submit('<i class="fa fa-trash"></i><span class="sr-only">Delete</span>')->addClass('btn btn-xs btn-danger')->removeClass('btn-default')->data('toggle', 'tooltip')->data('placement', 'top')->title('Delete') !!}
                            {!! BootForm::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('footer-extras')
    {{-- Data Table Scripts --}}
    <script src="{{ asset('vendor/odotmedia/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/odotmedia/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('#users').dataTable({
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false
                }]
            });
        });
    </script>
@stop