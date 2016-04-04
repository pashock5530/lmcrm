@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') {!! trans("admin/characteristics.characteristic") !!} :: @parent
@stop

{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            {!! trans("admin/characteristics.characteristic") !!}
            <div class="pull-right flip">
                <div class="pull-right flip">
                    <a href="{!! URL::to('admin/characteristics/create') !!}"
                       class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> {{ trans("admin/modal.new") }}</a>
                </div>
            </div>
        </h3>
    </div>

    <table id="table" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>{!! trans("admin/characteristics.name") !!}</th>
            <th>{!! trans("admin/characteristics.group") !!}</th>
            <th>{!! trans("admin/admin.created_at") !!}</th>
            <th>{!! trans("admin/admin.action") !!}</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')
@stop
