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
            <a class="btn btn-primary btn-xs close_popup" href="{{ URL::previous() }}">
                <span class="glyphicon glyphicon-backward"></span> {!! trans('admin/admin.back') !!}
            </a>
        </div>
        </h3>
    </div>
    <div class="container" id="content">
        <div class="wizard">
            <ul>
                <li><a href="#tab1" data-toggle="tab" class="btn btn-circle">1</a></li>
                <li><a href="#tab2" data-toggle="tab" class="btn btn-circle">2</a></li>
            </ul>
            <div class="progress progress-striped">
                <div class="progress-bar progress-bar-info bar"></div>
            </div>
            <div class="tab-content">
                <div class="tab-pane" id="tab1">
                    <form method="post" id="jSplash-form" class="form-horizontal noEnterKey _validate" action="#" >
                        <div class="jSplash-data" id="opt"> Loading... </div>

                        <div class="form jSplash-data" id="cform"> Loading... </div>
                    </form>
                </div>
                <div class="tab-pane text-right" id="tab2">
                    <button class="btn btn-warning btn-save btn-raised">Save</button>
                </div>
                <ul class="pager wizard">
                    <li class="previous first" style="display:none;"><a href="#">First</a></li>
                    <li class="previous"><a href="#">Previous</a></li>
                    <li class="next last" style="display:none;"><a href="#">Last</a></li>
                    <li class="next"><a href="#">Next</a></li>
                </ul>
            </div>
        </div>
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
    <script type="text/javascript" src="{{ asset('components/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}" async></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/markerclusterer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/GMapInit.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/sly.min.js') }}" async></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/jSplash.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $('.wizard').bootstrapWizard({
                'tabClass': 'nav nav-pills',
                'onTabShow': function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                navigation.closest('.wizard').find('.bar').css({width:$percent+'%'});
            }});

            $.ajax({
                url:  '{{ route('admin.chrct.form',[$fid]) }}',
                method: 'GET',
                dataType: 'json',
                success: function(resp){
                    for(var k in resp) {
                       var $el = $('#content').find('#'+k);
                        if($el.length) $el.jSplash().data('splash').load({data:resp[k]},false,{}).show();
                    }
                }
            });

//            $('#content .form').jSplash().data('splash').load('{{ route('admin.chrct.form',[$fid]) }}',true,{}).show();

            $('#content .btn-save').click(function(){
                var postData = {};
                var $jElements = $('#content .jSplash-data');
                var $this = $(this);
                for(var i=0; i<$jElements.length;i++) {
                    postData[$jElements.eq(i).attr('id')] = $jElements.eq(i).data('splash').serialize();
                }

                if(postData) {
                    $this.prop('disabled',true);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('admin.characteristics.update',[$fid]) }}',
                        method: 'PUT',
                        data: postData,
                        success: function (data, textStatus) {
                            $this.prop('disabled',false);
                            //window.location = '{{ route('admin.characteristics.index') }}';
                            //location.reload();

                            //window.location.href = window.location.href;
                        },
                        error: function (XMLHttpRequest, textStatus) {
                            alert(textStatus);
                            $this.prop('disabled',false);
                        }
                    });
                };
                return false;
            });
        });
    </script>
@stop