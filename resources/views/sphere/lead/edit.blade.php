@extends('layouts.master')

{{-- Content --}}
@section('content')
    <div class="page-header">
        <div class="pull-right flip">
            <a class="btn btn-primary btn-xs close_popup" href="{{ URL::previous() }}">
                <span class="glyphicon glyphicon-backward"></span> {!! trans('admin/admin.back') !!}
            </a>
        </div>
    </div>
    <div class="container" id="content">
        {!! Form::model($sphere,array('route' => ['agent.sphere.update',$sphere->id], 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseLead"> <i class="fa fa-chevron-down pull-left flip"></i>  $attr->label </a>
                    </h4>
                </div>
                <div id="collapseLead" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <form method="post" class="jSplash-form form-horizontal noEnterKey _validate" action="#" >
                            <div class="form jSplash-data" id="lead"> Loading... </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseForm"> <i class="fa fa-chevron-down pull-left flip"></i>  $attr->label </a>
                    </h4>
                </div>
                <div id="collapseForm" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <form method="post" class="jSplash-form form-horizontal noEnterKey _validate" action="#" >
                            <div class="jSplash-data" id="cform">
                                Loading...
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::submit(trans('site/sphere.apply'),['class'=>'btn btn-default']) !!}
        {!! Form::close() !!}
    </div>
@stop