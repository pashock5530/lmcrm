@extends('layouts.master')

{{-- Content --}}
@section('content')
    <div class="_page-header" xmlns="http://www.w3.org/1999/html">
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12">
            <table class="table table-bordered table-striped table-hover ajax-dataTable">
                <thead>
                <tr>
                    <th>{!! trans("site/lead.count") !!}</th>
                    <th>{!! trans("main.open") !!}</th>
                    <th>{!! trans("main.status") !!}</th>
                    <th>{!! trans("site/lead.updated") !!}</th>
                    <th>{!! trans("site/lead.name") !!}</th>
                    <th>{!! trans("site/lead.phone") !!}</th>
                    <th>{!! trans("site/lead.email") !!}</th>
                    @forelse($lead_attr as $attr)
                    <th>{{ $attr->label }}</th>
                    @empty
                    @endforelse
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(function () {
        var dTable = $('.ajax-dataTable:first-child').DataTable({
            "oLanguage": {
                "sProcessing": "@lang('table.processing')",
                "sLengthMenu": "@lang('table.showmenu')",
                "sZeroRecords": "@lang('table.noresult')",
                "sInfo": "@lang('table.show')",
                "sEmptyTable": "@lang('table.emptytable')",
                "sInfoEmpty": "@lang('table.view')",
                "sInfoFiltered": "@lang('table.filter')",
                "sInfoPostFix": "",
                "sSearch": "@lang('table.search')",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "@lang('table.start')",
                    "sPrevious": "@lang('table.prev')",
                    "sNext": "@lang('table.next')",
                    "sLast": "@lang('table.last')"
                }
            },
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('agent.lead.obtain.data') }}",
        });
        $(document).delegate('.ajax-link','click',function(){
            var href=$(this).attr('href');
            $.ajax({
                url: href,
                method:'GET',
                success:function(){
                    dTable.ajax.reload();
               }
            });
            return false;
        });
    });
</script>
@stop