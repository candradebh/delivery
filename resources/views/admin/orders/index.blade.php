@extends('app')

@section('content')
    <h1 class="page-header">Pedidos</h1>
    <a href="{{route('admin.orders.create')}}" class="btn btn-default">Adicionar</a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Código</th>
                <th>Total</th>
                <th>Data</th>
                <th>Itens</th>
                <th>Entregador</th>
                <th>Status</th>
                <th>Ação</th>

            </tr>
            </thead>
            <tbody>

    @foreach($orders as $order )
            <tr>
                <td># {{ $order->id }}</td>
                <td>R$ {{ $order->total }}</td>
                <td>{{ $order->created_at}}</td>
                <td>
                    <ul>
                    @foreach($order->items as $item)

                        <li>{{$item->product->name}}</li>

                    @endforeach
                    </ul>
                </td>
                <td>
                    @if($order->deliveryman)
                        {{$order->deliveryman->name}}
                    @else
                        --
                    @endif
                </td>
                <td>{{ $order->status}}</td>
                <td>
                    <a href="{{route('admin.orders.edit',[$order->id])}}" class="btn btn-default btn-small">Editar</a>
                    <a href="{{route('admin.orders.destroy',[$order->id])}}" class="btn btn-danger btn-small">Excluir</a>
                </td>
            </tr>
    @endforeach
            </tbody>
        </table>

        {!! $orders->render() !!}
    </div>

@endsection