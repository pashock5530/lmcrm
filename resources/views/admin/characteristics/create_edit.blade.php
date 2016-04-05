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
            <form method="post" id="jSplash-form" class="form-horizontal noEnterKey _validate" action="#" >
                <div class="form"> Loading... </div>
            </form>
        <a class="btn btn-warning btn-save pull-right flip">Save</a>
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
                        <button type="button" class="btn btn-info " data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-raised btn-save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

{{-- Styles --}}
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('components/entypo/css/entypo.css') }}">
@stop
{{-- Scripts --}}
@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.4.2/Sortable.min.js" async></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/doT.min.js') }}" async></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/bootbox.min.js') }}" async></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/markerclusterer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/GMapInit.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/sly.min.js') }}" async></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/jSplash.js') }}"></script>
    <script type="text/javascript">
        $(function(){

            $('#content .form').jSplash().data('splash')
                    .load('{{ route('admin.chrct.form') }}',true,{}).show();
            $('#content .btn-save').click(function(){
                var postData = $('#content .form').data('splash').serialize();
                if(postData) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('admin.characteristics.store') }}',
                        method: 'POST',
                        data: postData,
                        success: function (data, textStatus) {
                            //window.location = location.href;
                            //location.reload();

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