@extends('app')

@section('content')
    <h2 class="sub-header">Novo Pedido</h2>

    @include('errors._check')

    {!! Form::open(['route'=>'admin.orders.store']) !!}

        @include('admin.orders._form')

        <div class="form-group">
             {!! Form::submit('Criar',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection