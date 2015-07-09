@extends($viewNamespace . '::layouts.master')
@section('title', 'Permissions - Dashboard')
@section('header-extras')
    {{-- Data Tables Styles --}}
    <link href="{{ asset('vendor/odotmedia/data-tables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/odotmedia/data-tables/css/dataTables.responsive.css') }}" rel="stylesheet" type="text/css">
@stop
@section('page-wrapper')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Permissions
                    <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-default pull-right" data-toggle="tooltip" data-placement="left" title="Add New Permission"><i class="fa fa-plus"></i></a>
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
                        <table class="table table-striped table-bordered table-hover" id="dataTables-permissions">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th class="datatable-nosort">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr class="">
                                    <td class="text-center col-xs-1">
                                        <a href="{{ route('permissions.edit', ['id' => $permission->id]) }}">{{ $permission->id }}</a>
                                    </td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->slug }}</td>
                                    <td class="text-center col-xs-1">
                                        {!! BootForm::open()->delete()->action(route('permissions.delete', ['id' => $permission->id])) !!}
                                        <a href="{{ route('permissions.edit', ['id' => $permission->id]) }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
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
            $('#dataTables-permissions').DataTable({
                responsive: true,
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false
                }]
            });
        });
    </script>
@stop