@extends('layouts.master')

{{-- Content --}}
@section('content')
    <div class="_page-header" xmlns="http://www.w3.org/1999/html"></div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12">
                <select data-name="date" class="selectbox dataTables_filter">
                    <option></option>
                    <option value="2d">last 2 days</option>
                    <option value="1m">last month</option>
                </select>
                <select data-name="pageLength" class="selectbox dataTables_filter" data-js="1">
                    <option></option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
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
            "searching": false,
            "lengthChange": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"{{ route('agent.lead.obtain.data') }}",
                "data": function(d){
                    var filter={};
                    $(".dataTables_filter").each(function(){
                        if($(this).data('name') && $(this).data('js')!=1) { filter[$(this).data('name')]=$(this).val(); }
                    });
                    d['filter']=filter;
                },
            }
        });
        $(".dataTables_filter").change(function(){
            if($(this).data('js')=='1') {
                switch ($(this).data('name')) {
                    case 'pageLength':
                        if($(this).val()) dTable.page.len($(this).val()).draw();
                        break;
                    default: ;
                }
            } else {
                dTable.ajax.reload();
            }
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
        dTable.ajax.reload();
    });
</script>
@stop