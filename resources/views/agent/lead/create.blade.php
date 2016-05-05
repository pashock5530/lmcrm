@extends('layouts.master')
{{-- Content --}}
@section('content')
    {!! Form::open(array('route' => ['agent.lead.store'], 'method' => 'post', 'files'=> false)) !!}

    <div class="form-group  {{ $errors->has('first_name') ? 'has-error' : '' }}">
        <div class="col-xs-10">
            {!! Form::text('name', null, array('class' => 'form-control','placeholder'=>trans('lead/form.name'))) !!}
            <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
        </div>
        <div class="col-xs-2">
            <img src="/public/icons/list-edit.png" class="icon pull-left flip">
        </div>
    </div>

    <div class="form-group  {{ $errors->has('first_name') ? 'has-error' : '' }}">
        <div class="col-xs-10">
            {!! Form::text('phone', null, array('class' => 'form-control','placeholder'=>trans('lead/form.phone'))) !!}
            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
        </div>
        <div class="col-xs-2">
            <img src="/public/icons/list-edit.png" class="icon pull-left flip">
        </div>
    </div>

    <div class="form-group  {{ $errors->has('first_name') ? 'has-error' : '' }}">
        <div class="col-xs-10">
            {!! Form::textarea('comment', null, array('class' => 'form-control','placeholder'=>trans('lead/form.comments'))) !!}
            <span class="help-block">{{ $errors->first('comment', ':message') }}</span>
        </div>
        <div class="col-xs-2">
            <img src="/public/icons/list-edit.png" class="icon pull-left flip">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-10">
            {!! Form::submit(trans('save'),['class'=>'btn btn-info pull-right flip']) !!}
        </div>
        <div class="col-xs-2"></div>
    </div>

    {!! Form::close() !!}
@stop