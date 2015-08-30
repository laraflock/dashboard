{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.users.all.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.users.all.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.users.all.page_subtitle'))

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
            <h3 class="box-title">{{ trans('dashboard::dashboard.users.all.table_title') }}</h3>
        </div>
        <div class="box-body">
            <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ trans('dashboard::dashboard.table.id') }}</th>
                    <th>{{ trans('dashboard::dashboard.table.first_name') }}</th>
                    <th>{{ trans('dashboard::dashboard.table.last_name') }}</th>
                    <th>{{ trans('dashboard::dashboard.table.email') }}</th>
                    <th>{{ trans('dashboard::dashboard.table.role') }}</th>
                    <th class="datatable-nosort">{{ trans('dashboard::dashboard.table.actions') }}</th>
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
                            <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="{{ trans('dashboard::dashboard.buttons.edit') }}"><i class="fa fa-pencil"></i></a>
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