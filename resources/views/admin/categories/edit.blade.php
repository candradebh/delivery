@extends('app')

@section('content')
    <h2 class="sub-header">Editando Categoria: {{$category->name}}</h2>

    @include('errors._check')

    {!! Form::model($category, ['route'=>['admin.categories.update',$category->id]]) !!}

    @include('admin.categories._form')

        <div class="form-group">
             {!! Form::submit('Salvar',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection