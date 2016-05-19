@extends('app')

@section('content')
    <h2 class="sub-header">Novo Produto</h2>

    @include('errors._check')

    {!! Form::open(['route'=>'admin.products.store']) !!}

        @include('admin.products._form')

        <div class="form-group">
             {!! Form::submit('Criar',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection