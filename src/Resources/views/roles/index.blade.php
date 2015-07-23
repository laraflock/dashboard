@extends($viewNamespace . '::layouts.master')
@section('title', 'Roles - Dashboard')
@section('page-title', 'Roles')
@section('page-subtitle', 'All Roles')
@section('header-extras')
    {{-- Data Table Styles --}}
    <link href="{{ asset('vendor/laraflock/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
@stop
@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Roles</h3>
        </div>
        <div class="box-body">
            <table id="roles" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th class="datatable-nosort">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr class="">
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->slug }}</td>
                        <td class="text-center col-xs-1">
                            {!! BootForm::open()->delete()->action(route('roles.delete', ['id' => $role->id])) !!}
                            <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
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
    <script src="{{ asset('vendor/laraflock/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/laraflock/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('#roles').dataTable({
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false
                }]
            });
        });
    </script>
@stop