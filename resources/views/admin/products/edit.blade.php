@extends('app')

@section('content')
    <h2 class="sub-header">Editando produto: {{$product->name}}</h2>

    @include('errors._check')

    {!! Form::model($product, ['route'=>['admin.products.update',$product->id]]) !!}

    @include('admin.products._form')

        <div class="form-group">
             {!! Form::submit('Salvar',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection