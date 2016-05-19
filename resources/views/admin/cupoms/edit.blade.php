@extends('app')

@section('content')
    <h2 class="sub-header">Editando Cupom ID: {{$cupom->id}}</h2>
    <h3>Codigo {{$cupom->code}} </h3>
    @include('errors._check')

    {!! Form::model($cupom, ['route'=>['admin.cupoms.update',$cupom->id]]) !!}

    @include('admin.cupoms._form')

        <div class="form-group">
             {!! Form::submit('Salvar',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection