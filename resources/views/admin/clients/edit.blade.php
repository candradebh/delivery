@extends('app')

@section('content')
    <h2 class="sub-header">Editando Cliente: {{$client->user->name}}</h2>

    @include('errors._check')

    {!! Form::model($client, ['route'=>['admin.clients.update',$client->id]]) !!}

    @include('admin.clients._form')

        <div class="form-group">
             {!! Form::submit('Salvar',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection