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
        {!! Form::model($sphere,array('route' => ['operator.sphere.lead.update','sphere'=>$sphere->id,'id'=>$lead], 'method' => 'put', 'class' => 'validate', 'files'=> false)) !!}
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseLead"> <i class="fa fa-chevron-down pull-left flip"></i>  $attr->label </a>
                    </h4>
                </div>
                <div id="collapseLead" class="panel-collapse collapse in">
                    <div class="panel-body">
                        @forelse($sphere->leadAttr as $attr)
                            <h3 class="page_header">{{ $attr->label }} </h3>
                            @if ($attr->_type == 'checkbox')
                                @foreach($attr->options as $option)
                                    <div class="form-group">
                                        <div class="checkbox">
                                            {!! Form::checkbox('info['.$attr->id.']',$option->id, isset($leadInfo[$option->id])?$leadInfo[$option->id]:null, array('class' => '','id'=>"ch-$option->id")) !!}
                                            <label for="ch-{{ $option->id }}">{{ $option->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif ($attr->_type == 'radio')
                                @foreach($attr->options as $option)
                                    <div class="form-group">
                                        <div class="radio">
                                            {!! Form::radio('info['.$attr->id.']',$option->id, isset($leadInfo[$option->id])?$leadInfo[$option->id]:null, array('class' => '','id'=>"r-$option->id")) !!}
                                            <label for="r-{{ $option->id }}">{{ $option->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif ($attr->_type == 'select')
                                <div class="form-group">
                                    {!! Form::select('info['.$attr->id.']',$attr->options->lists('name','id'),isset($leadInfo[$attr->id])?$leadInfo[$attr->id]:null, array('class' => '')) !!}
                                </div>
                            @elseif ($attr->_type == 'email')
                                <div class="form-group">
                                    {!! Form::email('info['.$attr->id.']',isset($leadInfo[$attr->id])?$leadInfo[$attr->id]:null, array('class' => 'form-control','data-rule-email'=>true)) !!}
                                </div>
                            @elseif ($attr->_type == 'input')
                                <div class="form-group">
                                    {!! Form::text('info['.$attr->id.']',isset($leadInfo[$attr->id])?$leadInfo[$attr->id]:null, array('class' => 'form-control')+$attr->validatorRules()) !!}
                                </div>
                            @elseif ($attr->_type == 'calendar')
                                <div class="form-group">
                                    <div class="input-group">
                                    {!! Form::text('info['.$attr->id.']',isset($leadInfo[$attr->id])?$leadInfo[$attr->id]:null, array('class' => 'form-control datepicker')) !!}
                                        <div class="input-group-addon"> <a href="#"><i class="fa fa-calendar"></i></a> </div>
                                    </div>
                                </div>
                            @else
                                <br/>
                            @endif
                        @empty
                        @endforelse
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
                        @forelse($sphere->attributes as $attr)
                            <h3 class="page_header">{{ $attr->label }} </h3>
                                @if ($attr->_type == 'checkbox')
                                  @foreach($attr->options as $option)
                                   <div class="form-group">
                                        <div class="checkbox">
                                            {!! Form::checkbox('options[]',$option->id, isset($mask[$option->id])?$mask[$option->id]:null, array('class' => '','id'=>"ch-$option->id")) !!}
                                            <label for="ch-{{ $option->id }}">{{ $option->name }}</label>
                                        </div>
                                   </div>
                                  @endforeach
                                @elseif ($attr->_type == 'radio')
                                 @foreach($attr->options as $option)
                                  <div class="form-group">
                                    <div class="radio">
                                        {!! Form::radio('options[]',$option->id, isset($mask[$option->id])?$mask[$option->id]:null, array('class' => '','id'=>"r-$option->id")) !!}
                                        <label for="r-{{ $option->id }}">{{ $option->name }}</label>
                                    </div>
                                  </div>
                                 @endforeach
                                @elseif ($attr->_type == 'select')
                                  <div class="form-group">
                                        {!! Form::select('options[]',$attr->options->lists('name','id'),$attr->id, array('class' => '')) !!}
                                  </div>
                                @else
                                    I am  else <br/>
                                @endif
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {!! Form::submit(trans('site/sphere.apply'),['class'=>'btn btn-default']) !!}
        {!! Form::close() !!}
    </div>
@stop