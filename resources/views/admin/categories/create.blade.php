@extends('app')

@section('content')
    <h2 class="sub-header">Nova Categoria</h2>

    @include('errors._check')

    {!! Form::open(['route'=>'admin.categories.store']) !!}

        @include('admin.categories._form')

        <div class="form-group">
             {!! Form::submit('Criar',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection