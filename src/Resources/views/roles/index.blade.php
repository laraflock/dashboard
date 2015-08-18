{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', 'Roles - Dashboard')

{{-- Page Title --}}
@section('page-title', 'Roles')

{{-- Page Subtitle --}}
@section('page-subtitle', 'All Roles')

{{-- Header Extras to be Included --}}
@section('header-extras')
    {{-- Data Table Styles --}}
    <link href="{{ asset('vendor/laraflock/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
@stop

{{-- Content Section --}}
@section('content')

    {{-- DataTable Box --}}
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ trans('dashboard::dashboard.roles.all.table_title') }}</h3>
        </div>
        <div class="box-body">
            <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ trans('dashboard::dashboard.table.name') }}</th>
                    <th>{{ trans('dashboard::dashboard.table.slug') }}</th>
                    <th class="datatable-nosort">{{ trans('dashboard::dashboard.table.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr class="">
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->slug }}</td>
                        <td class="text-center col-xs-1">
                            {!! BootForm::open()->delete()->action(route('roles.delete', ['id' => $role->id])) !!}
                            <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="{{ trans('dashboard::dashboard.buttons.edit') }}"><i class="fa fa-pencil"></i></a>
                            {!! BootForm::submit('<i class="fa fa-trash"></i><span class="sr-only">' . trans('dashboard::dashboard.buttons.delete') . '</span>')->addClass('btn btn-xs btn-danger')->removeClass('btn-default')->data('toggle', 'tooltip')->data('placement', 'top')->title(trans('dashboard::dashboard.buttons.delete')) !!}
                            {!! BootForm::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

{{-- Footer Extras to be Included --}}
@section('footer-extras')

    {{-- Data Table Scripts --}}
    <script src="{{ asset('vendor/laraflock/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/laraflock/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

    {{-- Initiate DataTable --}}
    <script type="text/javascript">
        $(function () {
            $('#index').dataTable({
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false
                }]
            });
        });
    </script>
@stop