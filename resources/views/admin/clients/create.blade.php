@extends('app')

@section('content')
    <h2 class="sub-header">Novo Cliente</h2>

    @include('errors._check')

    {!! Form::open(['route'=>'admin.clients.store']) !!}

        @include('admin.clients._form')

        <div class="form-group">
             {!! Form::submit('Criar',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection