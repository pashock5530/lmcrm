@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') {!! trans("admin/characteristics.characteristic") !!} :: @parent
@stop

{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            {!! trans("admin/characteristics.characteristic") !!}
        </h3>
    </div>
    <div class="container" id="content">
        <div class="form"> Loading... </div>
        <a class="btn btn-warning">Save</a>
    </div>

    <div class="modal fade" id="modal-page">
        <div class="modal-dialog">
            <form class="validate">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop


{{-- Scripts --}}
@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.4.2/Sortable.min.js" async></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/doT.min.js') }}" async></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/bootbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/markerclusterer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/GMapInit.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/sly.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/jSplash.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            var cdata = {"CustomForm":{"renderType":"dynamicForm","targetEntity":"AppLayout\\Entity\\Darkley\\Element\\CustomForm","id":null,"values":[],"settings":{"label":"Dynamic Form","view":{"show":"form.dynamic","edit":"modal.dynamic"},"form.dynamic":[],"button":"Add field"}}}

            $('#content .form').jSplash().data('splash')
                    .load(cdata,false,{}).show();

            $('#content .btn-save').click(function(){
                var postData = $('#content .form').data('splash').serialize();
                if(postData) {
                    $.ajax({
                        url: '/app/user/edit-app-style-save',
                        method: 'POST',
                        data: postData,
                        success: function (data, textStatus) {
                            window.location = location.href;
                            location.reload();

                            //window.location.href = window.location.href;
                        },
                        complete: function (XMLHttpRequest, textStatus) {
                            //console.info(XMLHttpRequest);
                        }
                    });
                };
                return false;
            });
        });
    </script>
@stop