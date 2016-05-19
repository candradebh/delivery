@extends('app')

@section('content')
    <h2 class="sub-header">Pedido: #{{$order->id}} - R$ {{$order->total}}</h2>
    <h4>Cliente: {{$order->client->user->name}}</h4>
    <h5>Data: {{$order->created_at}}</h5>
    <p>
        <b>Entregar em:</b><br>
        {{$order->client->address}} - {{$order->client->city}} - {{$order->client->state}}
    </p>
    <br>
    @include('errors._check')

    {!! Form::model($order, ['route'=>['admin.orders.update',$order->id]]) !!}

    @include('admin.orders._form')

        <div class="form-group">
             {!! Form::submit('Salvar',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection