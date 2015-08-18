{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.dashboard.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.dashboard.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', '')

{{-- Content Section --}}
@section('content')
    <h1>This is your main dashboard landing page. This should show a summary of things going on in the application.</h1>
@stop