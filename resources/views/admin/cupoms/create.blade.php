@extends('app')

@section('content')
    <h2 class="sub-header">Novo Cupom</h2>

    @include('errors._check')

    {!! Form::open(['route'=>'admin.cupoms.store']) !!}

        @include('admin.cupoms._form')

        <div class="form-group">
             {!! Form::submit('Criar',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection